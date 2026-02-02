<?php

namespace App\Http\Controllers;

use Exception;
use App\Mail\{ActivateAccountClient, ResetPasswordClient};
use App\Models\{Outil, User, Client, Commande, Couleur, DeclinaisonProduit, Depot, Es, EsProduit, NiveauHabilite, Produit, Taille};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, Hash, Mail};

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $request->validate(
            [
                'email'     => 'required',
                'password'  => 'required'
            ]
        );

        $email = $request->email;
        $password = $request->password;

        $isClient = $request->path() == 'connexion_sw';

        $user = $isClient ?
            Client::where('email', $email)->first() :
            User::where('email', $email)->first();

        if ($user && Hash::check($password, $user->password))
        {
            /**
             * Test si le compte est actif
             */
            if (!$user->can_login)
            {
                if ($isClient)
                {
                    throw new Exception("Votre compte n'est pas actif. Veuillez vérifier votre boite e-mail!");
                }

                return redirect()
                    ->back()
                    ->withInput($request->all())
                    ->withErrors(['msg' => "Votre compte n'est pas actif, veuillez contacter l'administratreur."]);
            }

            $can_generate_token = str_contains($request->path(), "connexion");

            if ($can_generate_token)
            {
                // $token = $request->user()->createToken($request->device_name ?? "master")->plainTextToken;
                // dd('here', $token);
                $abilities = [];
                if (!$isClient)
                {
                    array_push($abilities, "is_user");
                }
                $token  = explode('|', $user->createToken($request->device_name ?? "master", $abilities)->plainTextToken);
                $token = is_array($token) && isset($token[1]) ? $token[1] : null;
            }

            if ($isClient)
            {
                //TRAITEMENT DU PANIER

                $produits                        = isset($request->panier) ? $request->panier : [];
                $Cpanier = Es::where('client_id', $user->id)->where("etat",0)->first();
                if (is_null($Cpanier))
                {
                    $date = isset($this->request->date) ? $this->request->date : date('Y-m-d');
                    $date = (strpos($date, '/') !== false) ? Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d') : $date;
                    $Cpanier = new Commande();
                    $Cpanier->etat = 0;
                    $Cpanier->client_id = $user->id;
                    $Cpanier->date = $date;
                    $Cpanier->website = true;
                    $Cpanier->source = "commande ecommerce";
                    $Cpanier->type_document = 3;
                    $Cpanier->panier_valider = 0;
                    $Cpanier->niveau_habilite_id = NiveauHabilite::min("niveau") ;
                    $Cpanier->code = Outil::getCode(Commande::class, 'CMD');
                    $Cpanier->multiplicateur = -1;
                    // dd($Cpanier->depot_id = Depot::where("nom",'ilike','%web%')->first());
                    $Cpanier->depot_id = Depot::where("nom",'ilike','%web%')->count() > 0 ? Depot::where("nom",'ilike','%web%')->first()->id : null;
                    $Cpanier->save();
                }

                foreach ($produits as $key=>$value)
                {
                    //dd($value);
                    $declinaison = DeclinaisonProduit::find($value[0]['declinaison_id']);

                    if (isset($declinaison))
                    {
                        $produit = Produit::find($declinaison->produit_id);
                        $couleur = Couleur::find($declinaison->couleur_id);
                        $taille  = Taille::find($declinaison->taille_id);
                        $current_qte = Produit::getGoodQty(null, $Cpanier->depot_id, $declinaison->id);

                        // Suppression du panier
                        if ($value[0]['qte'] == 0)
                        {
                            $panierProduit = EsProduit::where("es_id",$Cpanier->id)->where('declinaison_produit_id',$value[0]['declinaison_id'])->first();
                            $panierProduit->delete();
                            $panierProduit->forceDelete();
                        }
                        else
                        {
                            if ($current_qte < $value[0]['qte'])
                            {
                                if ($current_qte == 0)
                                {
                                    throw new Exception("Il ne reste plus de {$produit->nom} {$couleur->nom} pour la taille {$taille->nom} en stock. ");
                                }
                                else
                                {
                                    throw new Exception("Il ne reste que {$current_qte} {$produit->nom} {$couleur->nom} pour la taille {$taille->nom} en stock. ");
                                }
                            }
                            else
                            {
                                $panierProduit = EsProduit::where("es_id",$Cpanier->id)->where('declinaison_produit_id',$value[0]['declinaison_id'])->first();
                                if (!isset($panierProduit))
                                {
                                    $panierProduit = new EsProduit ;
                                }
                                $panierProduit->es_id = $Cpanier->id;
                                $panierProduit->source = 'commande';
                                $panierProduit->qte = $value[0]["qte"];
                                $panierProduit->prix = $value[0]["prix"];
                                $panierProduit->total = $value[0]["qte"]*$value[0]["prix"];
                                $panierProduit->multiplicateur = -1;
                                $panierProduit->declinaison_produit_id = $declinaison->id;
                                $panierProduit->produit_id = $declinaison->produit_id;
                                $panierProduit->niveau_habilite_id = NiveauHabilite::where("niveau",NiveauHabilite::min("niveau"))->first()->id;
                                $panierProduit->depot_id = Depot::where("nom",'ilike','%web%')->first()->id ? Depot::where("nom",'ilike','%web%')->first()->id : null;
                                $panierProduit->save();
                            }
                        }
                    }
                    else
                    {
                        throw new Exception("Cette taille n'est plus disponible");
                    }
                }

                $total_commande = EsProduit::where("es_id",$Cpanier->id)->sum("total");
                //  dd($total_commande);
                $Cpanier->total = $total_commande;
                $Cpanier->save();
            }

            if ($can_generate_token)
            {
                return response()->json([
                    'data' => [
                        'token'     => $token,
                        'data'      => $user,
                        'success'   => 'Connexion réussie'
                    ]
                ]);
            }

            // dd('voilà');
            Auth::loginUsingId($user->id);
            return redirect('/');
        }

        if (str_contains("connexion", $request->path()))
        {
            return response()->json([
                'data' => [
                    'errors'     => "Vos identifiants de connexion sont incorrects!",
                ]
            ]);
        }

        return redirect()
            ->back()
            ->withInput($request->all())
            ->withErrors(['msg' => 'Vos identifiants de connexion sont incorrects!']);
    }

    /**
     * Permet create/update d'un client
     *
     * @param Request $request
     * @return void
     */
    public function register(Request $request)
    {
        $request->validate(
            [
                'username'              => 'bail|required',
                'email'                 => 'bail|required',
                'numero_telephone'      => 'nullable',
                'accept_newsletters'    => 'nullable',
                'accept_confidential'   => 'nullable',
                'password'              => 'bail|required|min:6',
            ]
        );

        if ($request->password !== $request->repassword) {
            throw new Exception("Veuillez saisir le même mot de passe!");
        }

        return DB::transaction(function () use ($request) {
            $client =  Client::where('email', $request->email)->first();

            if (is_null($client)) {
                $data = arrayWithOnly($request->all(), Client::class);
                $data['nom'] = $request->username;
                $data['remember_token'] = randomString(32);

                $client = Client::create($data);

                //if ($request->provider) {
                 //   dd($client->email);
                   // send mail
                    Mail::to($client->email)->send(
                        new ActivateAccountClient(
                            $client->remember_token,
                            $client->nom_complet
                        )
                    );
                    //$client->can_login = true;
                    //$client->activated_at = now();
                    $client->save();
              //  }

                return response()->json([
                    'data'  => [
                        'data'      => $client,
                        'success'   => 'Inscription réussie'
                    ]
                ]);
            }

            throw new Exception("L'utilisateur est déja inscrit");
        });
    }

    /**
     * Permet de mettre a jour un client
     *
     * @param Request $request
     * @return void
     */
    public function updateClient(Request $request)
    {
        $request->validate(
            [
                'username'          => 'bail|required',
                'email'             => 'bail|required',
                'numero_telephone'  => 'nullable',
                'password'          => 'bail|required|min:6',
            ]
        );

        // dd(Auth::user());
        if ($request->password !== $request->repassword) {
            throw new Exception("Veuillez saisir le même mot de passe!");
        }

        return DB::transaction(function () use ($request) {
            $client =  Client::where('email', $request->email)->first();

            if (is_null($client)) {
                throw new Exception("Le compte avec le e-mail {$request->email} n'existe pas");
            }

            $client->update(arrayWithOnly($request->all(), Client::class));

            return response()->json([
                'data'  => [
                    'data'      => $client,
                    'success'   => 'Mise à jour réussie'
                ]
            ]);
        });
    }

    /**
     * Permet de definir le nouveau mot de passe
     *
     * @param Request $request
     * @return void
     */
    public function setPassword(Request $request)
    {
        $request->validate([
            'password'  => 'required|min:6',
            'token'     => 'required',
            ]);

            if ($request->password !== $request->repassword) {
                throw new Exception("Veuillez saisir le même mot de passe");
            }

            return DB::transaction(function () use ($request) {
                $isClient = $request->path() == 'password-update';

                $user = $isClient ?
                Client::where('remember_token', $request->token)->first() :
                User::where('remember_token', $request->token)->first();

           // dd($user);
            if ($user) {
                $user->forceFill([
                    'remember_token'    => null,
                    'password'          => $request->password,
                    'can_login'          => true,
                ])->save();

                return response()->json([
                    'data'  => [
                        'data'      => $user,
                        'success'   => 'Mot de passe réinitialisé'
                    ]
                ]);
            } else {

                throw new Exception("Votre token a expiré");
            }
        });
    }

    /**
     * Permet d'envoyer un mail de demande de reset de mot de passe
     *
     * @param Request $request
     * @return void
     */
    public function resetPassword(Request $request)
    {
        //dd( $request);
        $request->validate([
            'email' => 'required'
        ]);
        $isClient = $request->path() == 'password-reset';

        $user = $isClient ?
            Client::where('email', $request->email)->first() :
            User::where('email', $request->email)->first();

        if ($user) {
            return DB::transaction(function () use ($user) {
                $user->forceFill([
                    'remember_token'    => randomString(32),
                    'can_login'         => false
                ])->save();

                // send mail
                //dd(config('env.ECOMMERCE_URL'));
                Mail::to($user->email)->send(
                    new ResetPasswordClient(
                        $user->remember_token,
                        $user->nom_complet
                    )
                );

                return response()->json([
                    'data'  => [
                        'success' => "Un email pour la réinitialisation de votre mot de passe vous a été envoyé."
                    ]
                ]);
            });
        }

        throw new Exception("Utilisateur introuvable");
    }

    public function activate(Request $request, string $token)
    {
        $isClient = str_ireplace("/{$token}", '', $request->path()) == 'activate-account';

        $user = $isClient ?
            Client::where('remember_token', $request->token)->first() :
            User::where('remember_token', $request->token)->first();

        if ($user) {
            return DB::transaction(function () use ($user, $isClient) {
                $user->forceFill([
                    'remember_token'    => null,
                    'can_login'         => true,
                ])->save();

                $toRedirect = "/";
                if ($isClient) {
                    $toRedirect = config('env.ECOMMERCE_URL');
                }
                //dd($toRedirect);
                return redirect()->away($toRedirect)
                    ->with(['data'  => $user, 'success' => 'Compte activé avec succés']);
            });
        }

        throw new Exception("Votre token a expiré");
    }

    public function logout(Request $request)
    {
        $user = auth()->user();

        if (Auth::guard('web')->check()) {
            Auth::logout();
        } else {
            $user->tokens()->delete();
        }

        $request->session()->invalidate();
        return response()->json(['message' => "Utilisateur déconnecté"]);
    }
}
