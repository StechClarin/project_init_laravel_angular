<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mpdf\Tag\U;
use App\Models\{
    Outil,
    User,
    Personnel,
    Remboursement,
    ValidationDossier,
    AvanceSalaire,
};
use DateTime;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;


class AvanceSalaireController extends EntityTypeController
{
    protected function getValidationRules(): array
    {
        return [

            'employe_id' => 'required',
            'montant' => 'required',
            'date' => 'required',
        ];
    }
    protected function getCustomValidationMessage(): array
    {
        return [
            'montant' => "Renseigner le montant",
            'employe_id' => "Renseigner l'employé",
            'date' => "Renseigner le date",
        ];
    }
    public function beforeValidateData():void
    {  

        $errors = null;
        $date = new DateTime(); 
        
        // $this->request['date']= $date->format('Y-m-d');
        if (isset($this->request->date)) {
            $date = DateTime::createFromFormat('d/m/Y', $this->request->date);
            if ($date) {
                $this->request->merge(['date' => $date->format('Y-m-d')]);
            }
        } 
        $this->request['restant'] = 0;

        if(isset($errors))
        {
            throw new \Exception($errors);
        }
    }

    public function saveRemboursement()
    {   
        return DB::transaction(function ()
        {
            $errors = "";
            $date = new DateTime(); 
            $remboursements = parseArray($this->request->remboursements, Remboursement::class);
            // dd($remboursements);
            $model = app($this->model)::find($this->request['avance_salaire_id']);

            if (!isset($model))
            {
                throw new \Exception("L'element n'existe pas dans le systeme");  
            }

            $this->modelId = $model->id;
            $line = 0;
            $remboursements = array_map(function ($remboursement) use(&$line, $model)
            {
                $line ++;
                if(empty($remboursement['date']))
                {
                    throw new \Exception("Veuillez selectionner la date, ligne:",$line);    
                }
                else 
                {
                    $date = DateTime::createFromFormat('d/m/Y',  $remboursement['date']);
                    if ($date) {
                        $remboursement['date'] = $date->format('Y-m-d');
                    }
                
                }
                if(!isset($remboursement["montant"]))
                {
                    throw new \Exception("Veuillez saisir le montant, ligne:",$line);    
                }
                return $remboursement;
            }, $remboursements);

            $model->saveHasManyRelation($remboursements, Remboursement::class); 
            $remboursement = DB::table('remboursements')  
                ->where('avance_salaire_id', $model->id);
               
            $montantRemboursement = $remboursement->sum('montant'); 
            $montantAvance = $model->montant ?? 0; 
            if ($montantRemboursement > $montantAvance) {  
                $errors = 'La somme des remboursements (' . $montantRemboursement . ') est supérieure au montant de l\'avance (' . $montantAvance . ')';
            }
            if(empty($errors))
            {
                $remboursement->orderBy('id', 'desc')->restant = $montantAvance - $montantRemboursement;
                $model->etat = $remboursement->orderBy('id', 'desc')->restant == 0 ? 2 : 1;
                // dd($model->save());
                $model->save();
                // $remboursement->save();
            }
            else
            {  
                throw new \Exception($errors);  
            }
            
            return $this->getGraphQLResponse();
        });
    }

    public function beforeDelete(): void
    {
        $errors = null;

        $remboursement = Remboursement::where('avance_salaire_id', $this->request->id);
        $remboursement->delete();
    }

    public function afterStatut($model): void
    {
        $messageEnCours = "Votre demande d'avance est en cours de traitement !";
        $messageRejetee = "Votre demande d'avance a été rejetée !";
        $messageValidee = "Votre demande d'avance a été validée !";
        $permission = "liste-avancesalaire";
    
        $personnel = Personnel::find($model->employe_id);
        if ($personnel && $personnel->email) {
            $user = User::where('email', $personnel->email)->first();
            // dd($personnel, $user);

            if ($user) {
                switch ($model->status) {
                    case 2:
                        $message = "Bonjour {$user->name},\n\n{$messageValidee}";
                        break;
                    case 1:
                        $message = "Bonjour {$user->name},\n\n{$messageRejetee}";
                        break;
                    default:
                        $message = "Bonjour {$user->name},\n\n{$messageEnCours}";
                        break;
                }
    
                Outil::SendNotification(
                    $message,
                    'demandeabsence', 
                    $user,
                    $permission, 
                );
            }
            
        }
    }
    
}