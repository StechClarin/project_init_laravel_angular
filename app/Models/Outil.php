<?php

namespace   App\Models;

use App\Notifications\EndUploadExcelFileNotification;
use Carbon\Carbon;
use App\Events\RtEvent;
use App\Exports\DatasExport;
use Illuminate\Http\Request;
use App\Events\SendNotifEvent;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\{App, Auth, DB, File, Log, Mail, Validator};
use App\Models\{TypeCommande, TypeBillet};
use App\Mail\Maileur;

class Outil extends Model
{
    // ********************************************************** //
    // *********************** UTILITAIRES ********************** //
    // ********************************************************** //
    public static $guzzleOptions = ['auth' => ['guindytechnology@gmail.com', 'guindyBINGO@2022']];

    public static function getAPI()
    {
        return config('env.APP_URL');
    }

    public static function getMsgError()
    {
        return config('env.MSG_ERROR');
    }

    public static function getResponseError(\Exception $e)
    {
        return response()->json(array(
            'errors'          => [$e->getCode() == 0 ? $e->getMessage() : config('env.MSG_ERROR')],
            'errors_debug'    => [$e->getMessage()],
            'errors_line'     => [$e->getLine()],
            'errors_trace'    => [$e->getTrace()],
        ));
    }

    // Format Date
    public static function formatDate($fr = false, $optionals = ['getSeparator' => false, 'withHours' => true])
    {

        if (!isset($optionals['getSeparator']) || !$optionals['getSeparator']) {
            return ($fr ? "d/m/Y" : "Y-m-d") . (!isset($optionals['withHours']) || $optionals['withHours'] ? " H:i:s" : "");
        } else {
            return "/";
        }
    }

    // Format Price
    public static function formatWithThousandSeparator($valeur)
    {
        return number_format($valeur, 0, '.', ' ');
    }

    // initialisation des parameters init
    public static function getOneItemWithFilterGraphQl($queryName, $filter, array $listeattributs_filter = null)
    {
        if ($queryName == 'valorisationdepots')
        {
            $queryName ='depots';
        }
        // dd($filter);
        $guzzleClient = new \GuzzleHttp\Client();

        $critere = !empty($filter) ? '(' . $filter . ')' : "";
These
        $queryAttr = self::$queries[$queryName];
       
        $add_text_filter = "";
        if (isset($listeattributs_filter)) {
            foreach ($listeattributs_filter as $key => $one) {
                $queryAttr = str_replace($one . ",", "", $queryAttr); // Si le paramètre existe, on le remplace dans la chaine de caractère

                $getAttr = $one;
                $reste = "";
                if (strpos($one, "{") !== false) {
                    $getAttr = substr($one, 0, strpos($one, "{"));
                    $reste = substr($one, strpos($one, "{"));
                }

                $add_text_filter .= (($key === 0) ? ',' : '') . $getAttr . $critere . $reste . (count($listeattributs_filter) - $key > 1 ? ',' : '') ;
            }
        }

        if ($queryName == 'valorisationproduits')
        {
            $queryName ='produits';
            $queryAttr.=",valorisation{$critere},current_qty";
        }

        // dd($queryName,$queryAttr);
        $parameter_client_id = null;
        if (Auth::user() && isset(Auth::user()->client_id)) {
            $parameter_client_id = "client_id=" . (Auth::user()->client_id) . "&";
        }
        // dd($parameter_client_id);
        $url = self::getAPI() . "graphql?{$parameter_client_id}query={{$queryName}{$critere}{{$queryAttr}{$add_text_filter}}}";
        // dd($url);
        $response = $guzzleClient->request('GET', $url, self::$guzzleOptions);
        // dd($response->getBody());
        $data = json_decode($response->getBody(), true);
        // dd($data);
        // dd($data['data'][$queryName]);

        return $data['data'][$queryName];
    }

    public static function getItemsWithGraphQl($queryName, $critere)
    {
        $guzzleClient = new \GuzzleHttp\Client([
            'defaults' => [
                'exceptions' => true
            ]
        ]);
        $queryAttr = self::$queries[$queryName];

        $response = isset($critere) ? $guzzleClient->get(self::getAPI() . "/graphql?query={{$queryName}({$critere}){{$queryAttr}}}") : $guzzleClient->get(self::getAPI() . "/graphql?query={{$queryName}{{$queryAttr}}}");
        
        $data = json_decode($response->getBody(), true);
        return $data;
    }

    public static function donneValeurCheckbox($valeur=null)
    {

        $retour = 0;

        if (isset($valeur))
        {
            $retour =  1  ;
        }
        return $retour;
    }

    public static function Prix_en_monetaire($nbre)
    {
    $rslt = "";
    $position = strpos($nbre, '.');
    if ($position === false)
    {
        //---C'est un entier---//
        //Cas 1 000 000 000 à 9 999 000
        if (strlen($nbre) >= 9) {
            $c = substr($nbre, -3, 3);
            $b = substr($nbre, -6, 3);
            $d = substr($nbre, -9, 3);
            $a = substr($nbre, 0, strlen($nbre) - 9);
            $rslt = $a . ' ' . $d . ' ' . $b . ' ' . $c;
        } //Cas 100 000 000 à 9 999 000
        elseif (strlen($nbre) >= 7 && strlen($nbre) < 9) {
            $c = substr($nbre, -3, 3);
            $b = substr($nbre, -6, 3);
            $a = substr($nbre, 0, strlen($nbre) - 6);
            $rslt = $a . ' ' . $b . ' ' . $c;
        } //Cas 100 000 à 999 000
        elseif (strlen($nbre) >= 6 && strlen($nbre) < 7) {
            $a = substr($nbre, 0, 3);
            $b = substr($nbre, 3);
            $rslt = $a . ' ' . $b;
            //Cas 0 à 99 000
        } elseif (strlen($nbre) < 6) {
            if (strlen($nbre) > 3) {
                $a = substr($nbre, 0, strlen($nbre) - 3);
                $b = substr($nbre, -3, 3);
                $rslt = $a . ' ' . $b;
            } else {
                $rslt = $nbre;
            }
        }
    } else {
        //---C'est un décimal---//
        $partieEntiere = substr($nbre, 0, $position);
        $partieDecimale = substr($nbre, $position, strlen($nbre));
        //Cas 1 000 000 000 à 9 999 000
        if (strlen($partieEntiere) >= 9) {
            $c = substr($partieEntiere, -3, 3);
            $b = substr($partieEntiere, -6, 3);
            $d = substr($partieEntiere, -9, 3);
            $a = substr($partieEntiere, 0, strlen($partieEntiere) - 9);
            $rslt = $a . ' ' . $d . ' ' . $b . ' ' . $c;
        } //Cas 100 000 000 à 9 999 000
        elseif (strlen($partieEntiere) >= 7 && strlen($partieEntiere) < 9) {
            $c = substr($partieEntiere, -3, 3);
            $b = substr($partieEntiere, -6, 3);
            $a = substr($partieEntiere, 0, strlen($partieEntiere) - 6);
            $rslt = $a . ' ' . $b . ' ' . $c;
        } //Cas 100 000 à 999 000
        elseif (strlen($partieEntiere) >= 6 && strlen($partieEntiere) < 7) {
            $a = substr($partieEntiere, 0, 3);
            $b = substr($partieEntiere, 3);
            $rslt = $a . ' ' . $b;
            //Cas 0 à 99 000
        } elseif (strlen($partieEntiere) < 6) {
            if (strlen($partieEntiere) > 3) {
                $a = substr($partieEntiere, 0, strlen($partieEntiere) - 3);
                $b = substr($partieEntiere, -3, 3);
                $rslt = $a . ' ' . $b;
            } else {
                $rslt = $partieEntiere;
            }
        }
        if ($partieDecimale == '.0' || $partieDecimale == '.00' || $partieDecimale == '.000') {
            $partieDecimale = '';
        }
        $rslt = $rslt . '' . $partieDecimale;
    }
    return ($rslt);
    }

    //Créer le dossier s'il n'existe pas encore
    public static function creerDossier($lien)
    {
        try
        {
            $fichierExiste = file_exists($lien);
            if($fichierExiste == false)
            {
                mkdir($lien, 0755, true);
            }
            return true;
        }
        catch (\Exception $e)
        {
            //dd($e);
            Outil::textePourErreur("Erreur dans creerDossier ==> ".$e);
        }
    }

    // Verify if data is unique inside a model
    public static function isUnique(array $columnNme, $value, $id, $model)
    {
        if (isset($id)) {
            $query = app($model)->where('id', '!=', $id);
        } else {
            $query = app($model);
        }
        for ($i = 0; $i < count($columnNme); $i++) {
            $query = $query->where($columnNme[$i], $value[$i]);
        }
        return $query->first() == null;
    }

    // Get correct like en fonction currently SGBD
    public static function getOperateurLikeDB()
    {
        return config('database.default') == "mysql" ? "like" : "ilike";
    }

    // Gives the normalized name of the query according to the name of the database
    public static function getQueryNameOfModel($nameTable)
    {
        // dd($nameTable);
        return str_replace("_", "", $nameTable);
    }

    // Redirect after save from controller's save method
    public static function redirectIfModeliSSaved($item, $queryName = null)
    {
        $item->save();
       // self::setUpdatedAtUserId($item);
        $id = $item->id;

        if (!isset($queryName)) {
            $queryName = self::getQueryNameOfModel($item->getTable());
        }

        self::publishEvent(['type' => substr($queryName, 0, (strlen($queryName) - 1)), 'add' => true]);
        return self::redirectGraphql($queryName, "id:{$id}", self::$queries[$queryName]);
    }

     // Pour genere  les code de tout l'application
     public  static function  saveCode($item, $indicatif)
     {
         $dateCode = '';
         $dateCode = self::getDateEng(now(),'Y-m-d');
         $dateCode = str_replace('-','',$dateCode);
         $code = $indicatif. '-' . $dateCode . '' . self::generateCode($item->id);
         $item->code = $code;
        // dd($item);
         $item->save();
     }

     public  static function  FormatterCode($tables, $date)
     {
        $init = 1;
        $date    = self:: donneValeurDate( $date);
        $date= Carbon::parse($date)->format('Y-m-d');
        $debut   =   $date.' 00:00:00';
        $datefin =   $date.' 23:59:59';
        $year = date('Y',strtotime($date));
        $year = substr( $year, -2);
        $month = date('m',strtotime($date));
        $day = date('d',strtotime($date));
        $prefix = $year.$month.$day.'-';
        $maxValue = Commande::whereBetween('date', array($debut,  $datefin))->max('id');
        if(isset($maxValue))
        {
            $commande =Commande::find($maxValue);
            if(isset($commande))
            {
                $val =  explode('-',$commande->code)[1];
                $init += $val;
            }
        }
        return "CM".$prefix.$init;
     }

    public static function getAllClassesOf(array $directories)
    {
        $profondeur = "";
        $profondeur_2 = "";
        foreach ($directories as $directory)
        {
            $profondeur .= "{$directory}/";
            $profondeur_2 .= "\\{$directory}";
        }

        $classPaths = glob(app_path() . "/{$profondeur}*.php");

        $classes = array();
        $namespace = "App{$profondeur_2}\\";
        foreach ($classPaths as $classPath)
        {
            $segments = explode('/', $classPath);
            $classes[] = "\\". str_replace('.php', '', ($namespace . end($segments)));
        }
        return $classes;
    }

    public static function setParametersExecution()
    {
        ini_set('max_execution_time', -1);
        ini_set('max_input_time', -1);
        ini_set('pcre.backtrack_limit', 50000000000);
        ini_set('memory_limit', -1);
    }

    // Upload any file
    public static function uploadFileToModel(&$request, &$item, $file = "image", $subimage="image")
    {
        $attr_erase = $file . "_erase";
        if (!empty($request->file()) && isset($_FILES[$file]))
        {
            $fichier = $_FILES[$file]['name'];
        
            if (!empty($fichier))
            {
                $fichier_tmp = $_FILES[$file]['tmp_name'];
                $ext = explode('.', $fichier);
                // dd(self::getQueryNameOfModel($item->getTable()) . "/{$file}_" . $item->id . "." . end($ext));
                // $rename = config('view.uploads')['departements'] . "/{$file}_" . $item->id . "." . end($ext);
                $rename = "uploads/".self::getQueryNameOfModel($item->getTable()) . "/{$file}_" . $item->id . "." . end($ext);
// 
                move_uploaded_file($fichier_tmp, $rename);

                // Pour directement save le lien absolu ici
                $item->$subimage = self::resolveImageField($rename);
            }

        }
        else if (isset($request->$attr_erase))
        {
            // Allows you to delete the user's image
            $item->$subimage = null;
        }

        $item->save();
    }

    // Add automatically common attr to table
    public static function stringToTimeInCel($celTime)
    {
        $celTime .= ":00";
        $time_cel = explode(':', $celTime);
        $time_exact = '';
        if (isset($time_cel) && count($time_cel) > 0) {
            if (isset($time_cel[0])) {
                if (is_numeric($time_cel[0])) {
                    $time_exact .= $time_cel[0];
                    if (isset($time_cel[1])) {
                        if (is_numeric($time_cel[1])) {
                            $time_exact .= ":" . $time_cel[1];
                        }
                    } else {
                        $time_exact .= ":00";

                    }
                }


            }
        }
        return $time_exact;

    }

    // Upload any file
    // $options_id = ['cle', 'valeur']
    public static function uploadMultiFilesToModel($classNew, $foreignKeyColumn = 'produit_id', &$request, &$item, $file = "image", $options_id = ['couleur_id'])
    {
        $attr_erase = "eraseaff" . $file ;
        // dd($request->file());
        if (!empty($request->file()))
        {
            $fichier = $_FILES[$file]['name'];
            $fichier_tmp = $_FILES[$file]['tmp_name'];
            $ext = explode('.', $fichier);
            $rename = config('view.uploads')[self::getQueryNameOfModel($item->getTable())] . "/{$file}_" . $item->id . "." . end($ext);
            move_uploaded_file($fichier_tmp, $rename);
            $newImage = app($classNew)::where('name', $file)->first();
            if (!isset($newImage))
            {
                $newImage = new $classNew;
                $newImage->name = $file;
                $newImage->identify = "aff" . $file;
            }
            $newImage->url = $rename . '?date=' . (date('Y-m-d H:i'));
            $newImage->{$foreignKeyColumn} = $item->id;
            // dd(ImageProduit::get());
            if (count($options_id) > 1)
            {
                $newImage->{$options_id[0]} =  $options_id[1];
            }
            $newImage->save();
        }
        else if (isset($request->$attr_erase))
        {
            // Allows you to delete the user's image
            $oldimage = $classNew::where("{$foreignKeyColumn}", $item->id)->where('name', $file);
            $oldimage->delete();
            $oldimage->forceDelete();
        }
    }

    // Add automatically common attr to table
    public static function listenerUsers(&$table, $add = true)
    {
        if ($add)
        {
            $table->foreignId('created_at_user_id')->nullable()->constrained('users');
            $table->foreignId('updated_at_user_id')->nullable()->constrained('users');
        }
        else
        {
            $table->dropConstrainedForeignId('created_at_user_id');
            $table->dropConstrainedForeignId('updated_at_user_id');
        }
    }

    public static function setUpdatedAtUserId(Model &$item)
    {
        if ($item->wasChanged() || $item->isDirty()) {
            $item->updated_at_user_id = Auth::user()->id;
            $item->save();
        }
    }
    // Mettre la premeire lettre en majuscule
    public static function premereLettreMajuscule($val)
    {
        return ucfirst($val);
    }
    // Manage validations with laravel validators, during creation
    public static function createValidation($object, $rules, $messages)
    {
        // Create validation using Validation facade and pass in the Inputs, the rules and the error messages
        $validator = Validator::make($object, $rules, $messages);

        $obj = null;

        // If Validation fails 8
        if ($validator->fails()) {
            // Get all validations errors
            $errors = $validator->errors();

            // Create array and cast it to object
            $obj = (object) array('data' => null, 'errors' => $errors);
        }

        return $obj;
    }
   //Donne le bon format de la date selon que ca soit de type date ou de type datedropper
   public static function donneValeurDate($dateVal)
   {
       $retour = date('Y-m-d H:i:s');
       if (isset($dateVal))
       {
           $retour = (strpos($dateVal, Outil::formatdateShort(true, true)) !== false) ? Carbon::createFromFormat(Outil::formatdateShort(true), $dateVal)->format('Y-m-d H:i:s') : $dateVal;
       }

       return $retour;
   }

   //Donne le bon format de la date selon que ca soit de type date ou de type datedropper
   public static function DateHeure($dateVal,$heure)
   {
       $date         = date('Y-m-d');
       $Currentheure = date('H:i:s');

       if (isset($dateVal))
       {
           $date = (strpos($dateVal, Outil::formatdateShort(true, true)) !== false) ? Carbon::createFromFormat(Outil::formatdateShort(true), $dateVal)->format('Y-m-d') : $dateVal;
       }
       if($heure)
       {
        $Currentheure = $heure.':00';
       }
       return $date.' '.$Currentheure;
   }
   public static function formatdateShort($for_edit = false, $getSeparator = false)
   {
       if (!$getSeparator)
           return $for_edit ? "d/m/Y" : "Y-m-d H:i:s";
       else
           return "/";
   }

    // Redirects to the graphql
    public static function redirectGraphql($itemName, $critere, $liste_attributs)
    {
        $path = '{' . $itemName . '(' . $critere . '){' . $liste_attributs . '}}';
        return redirect('graphql?query=' . urlencode($path));
    }

    public static function getAttrtibutes($attributes, $column)
    {
        foreach ($attributes as $attribute) {
            if ($column == $attribute) {
                return true;
            }
        }
        return  false;
    }

    // Like name, resolve image with correct base_url
    public static function resolveImageField($image, $elseDefault = true)
    {
        if (!isset($image))
        {
            if ($elseDefault)
            {
                $image = "/assets/images/upload.jpg";
            }
        }
        else
        {
            if (!str_contains($image, "?date"))
            {
                // In the event that an image exists in the database, in versioning
                $image = $image . '?date=' . (date('Y-m-d H:i'));
            }
        }

        if (isset($image) && !str_contains($image, "http"))
        {
            return self::getAPI() . $image;
        }

        return $image;
    }

    public static function setDateToInitial($date)
    {
        $date = Carbon::parse($date);
        $dayOfTheWeek = $date->dayOfWeek;

        $weekMap = [
            0 => 'Dim',
            1 => 'Lun',
            2 => 'Mar',
            3 => 'Mer',
            4 => 'Jeu',
            5 => 'Ven',
            6 => 'Sam',
        ];

        return $weekMap[$dayOfTheWeek] . " " . $date->day;
    }

    public static function donneTitrePdfExcel($queryName, $id)
    {
        $retour = '';

        return $retour;
    }

    public static function GetTagFilter($filter)
    {
        $TagName = [];
        if (strpos($filter, ',') !== false)
        {
           $myarray= explode(',',  strval($filter));
           foreach ($myarray as $key => $value)
           {
                if(strpos($value, '_id') !== false)
                {
                    $Name =  explode('_id', strval($value))[0];
                    $calsse_name =  $Name.'s';
                    $val  =   explode(':', strval($value))[1];
                    $baseClass = class_basename( $calsse_name);
                    if(isset($baseClass))
                    {
                        $item = DB::table($baseClass)->where('id', $val)->first();
                        if(isset($item->nom) || isset($item->nom_complet))
                        {
                            if(strpos($Name, '_') !== false)
                            {
                                $Name = explode('_', strval($Name))[0]. " ".explode('_', strval($Name))[1];
                            }
                            array_push($TagName,
                            array(
                                'nom'                      => $Name,
                                'valeur'                   =>$item->nom ?? $item->nom_complet ,
                            ));
                        }
                    }
                }
                else if(isset($value))
                {
                    $myarray= explode(':',  strval($value));
                    if(count( $myarray) > 0 &&  $myarray[0] !="" && $myarray[0] !="in_progress" && $myarray[0] !="is_all" )
                    {
                        $Name  = $myarray[0];
                        $val   = $myarray[1];

                        $val  = $Name=='etat_commande'  ?( $val ==0 ? 'En Cours' : ( $val == 4 ? 'Terminées' : 'Cloturées')): $val;
                        $val  = $Name=='etat_paiement'  ?( $val ==0 ? 'Aucun' : ( $val == 1 ? 'Partiel' : 'Total')): $val;
                        $val  = $Name=='perte' ||   $Name=='offert' || $Name=='reclamation'  ?( $val ==0 ? 'Non' : ( $val == 1 ? 'Oui' : 'Tout')): $val;
                        if(strpos($Name, '_') !== false)
                        {
                            $Name = explode('_', strval($Name))[0]. " ".explode('_', strval($Name))[1];
                        }
                        if(strpos($Name, '_') !== false)
                        {
                            $Name = explode('_', strval($Name))[0]. " ".explode('_', strval($Name))[1];
                        }                        array_push($TagName,
                        array(
                            'nom'                      => $Name,
                            'valeur'                   => is_numeric($val)  ? 'Non ': $val ,
                        ));
                    }
                }
           }
        }
        return $TagName;
    }
    public static function generateFilePdfOrExcel(Request $request, $queryName, $type,$id = null)
    {
        self::setParametersExecution();
        $produits=null;
        $queryold=$queryName;

        $prefix = "document";

        if (strpos($queryName, $prefix) === 0)
        {
            $queryName = substr($queryName, strlen($prefix));
        }
        $typeprixventes=null;
        $pointventes=null;
        $queryticket = null;
        $queryName =  $queryName =="ticket"  || $queryName =="ticketproduction"  || $queryName =="ticketcommandeproduction" ? 'commandes':$queryName;
       // $queryName =  $queryName =="valorisationproduits"  || $queryName =="ticketproduction"  ? 'produits':$queryName;

        $titre = self::donneTitrePdfExcel($queryName, $id);
        $user        = Auth::user()->name;
        $object      = array_keys($request->all());

        $folder      = config('env.FOLDER');
        $filtre      = isset($id) ? "id:{$id}" : (count($object) > 0 && (!isset($folder) || strpos(end($object), $folder)==false) ? end($object) : "");

        $titre = self::donneTitrePdfExcel($queryName, $id);
        $data        = self::getOneItemWithFilterGraphQl($queryName, $filtre);
        // dd($data, $queryName);
        $tagFilter    = self::GetTagFilter($filtre);

        $details     = null;



    
        $position = 'landscape';
        if (isset($id))
        {
            $can_do = true;
            $filtre_detail         = "parent_id:$id";

            if($queryName=='entreestocks'|| $queryName=='sortiestocks')
            {
                $queryName_detail='entreesortiestockproduits';
            }
            else if ($queryold== 'ticket' ||  $queryold== 'ticketproduction' || $queryold== 'ticketcommandeproduction')
            {
                $queryName_detail      = "commandeproduits";
            }
            else if ($queryold== 'productions' ||  $queryold== 'assemblages' )
            {
                $queryName_detail      = "detailproductions";
            }
            else if($queryName=='depenses')
            {
                $queryName_detail='depensepostedepenses';
            }
            else if($queryName=='cloturecaisses')
            {
                $queryName_detail='cloturecaissemodepaiements';
            }
            else if($queryName=='demandeabsences')
            {
                $can_do = false;
            }
            else if($queryName=='rapportassistances')
            {
                $can_do = false;
                $position = 'portrait';
            }
            else
            {
                $queryNames = substr($queryName, 0, -1);

                $queryName_detail      = "{$queryNames}produits";
            }
            if($can_do)
            {
                $details                   = self::getOneItemWithFilterGraphQl($queryName_detail, $filtre_detail);
            }
        }
        if ($queryName=='entreestocks'|| $queryName=='sortiestocks')
        {
            $titre =  explode('stocks', $queryName)[0].'s stock';
            $queryName ='entreestocks';
        }
        
        if (count($data))
        {
            //dd($queryold);

            if ($queryName=="sousfamilleproduits")
            {
                $permission = "familleproduit";
            }
            else
            {
                $permission = substr( $queryName, 0, -1);
            }

            $permission = isset($id) ? "detail-".$permission : "list-".$permission;

            $addToLink            = (isset($id) ? "detail-" : "");

            $data                 = array('user' => $user, 'filtres' => $tagFilter , 'permission' => $permission, 'data' => $data, 'is_excel' => false,'pointventes' => $pointventes, 'produits' => $produits,  'typeprixventes' => $typeprixventes,  'titre' => $titre, 'details' => $details);
            // dd($data);

            if ($type == "pdf")
            {


                if($queryold=='ticket' ||  $queryold=='ticketproduction' || $queryold=='ticketcommandeproduction')
                {
                    $view =  $queryold=='ticket' ? 'ticket-commande' :( $queryold=='ticketcommandeproduction' ? 'ticket-commande-production' :'ticket-production');
                    $pdf = PDF::loadView("pdfs.".$view, $data);
                    $measure = array(0,0,170.772,650.197);
                    return $pdf->setPaper($measure, 'orientation')->stream();
                }
                else if ($queryticket !=null)
                {
                    $measure = array(0,0,225.772,650.197);

                    $pdf         = PDF::loadView("pdfs.{$addToLink}{$queryName}", $data);

                    return $pdf->setPaper($measure, 'orientation')->stream();
                }
                else if (isset($id))
                {
                    $pdf          = PDF::loadView("pdfs.{$addToLink}{$queryName}", $data)->setPaper('a4', $position );
                }
                else
                {
                    $pdf         = PDF::loadView("pdfs.{$addToLink}{$queryold}", $data);
                }
                if ($queryName=='commandes')
                {
                    $measure = array(0,0,950,950);


                    $pdf = App::make('dompdf.wrapper');
                    $pdf->getDomPDF()->set_option("enable_php", true);
                    $pdf->loadView('pdfs.commandes', $data);
                    if(isset($measure)){
                        $pdf->setPaper($measure);
                    }
                    return $pdf->stream("{$addToLink}{$queryName}");
                }
                return $pdf->stream("{$addToLink}{$queryName}");
            }
            else
            {
                return Excel::download(new DatasExport($data, $queryName, $id), "{$addToLink}{$queryName}.xlsx");
            }
        }
        else
        {
            return redirect()->back();
        }
    }
    //Sending Notification ..
    public static function SendNotification($messages, $link, $user, $permission)
    {
        // Sending notification
        $notif = new Notif();
        $notif->message = $messages;
        $notif->link = "#!/list-{$link}";
        $notif->icon  = $link  ?? null;
        $notif->save();

        $notifPermUser  = new NotifPermUser();
        $notifPermUser->notif_id = $notif->id;
        $notifPermUser->permission_id = Permission::where('name', $permission)->first()->id;
        $notifPermUser->user_id = $user->id;
        $notifPermUser->save();

        $eventNotif = new SendNotifEvent($notifPermUser);
        event($eventNotif);
    }

    // Used to send the report after importing an Excel file
    public static function atEndUploadData($pathFile, $generateLink, $report, $user, $totalToUpload, $totalUpload, $importOf)
    {
        // After import, we can delete the file
        if (file_exists($pathFile))
        {
            File::delete($pathFile);
        }

        // Sending notification
        $notif = new Notif();
        $notif->message = "Fin de l'import du fichier excel {$importOf}, Merci de consulter vos mails pour le rapport";
        $namePage = "#!/list-{$generateLink}";
        $notif->link = $namePage;
        $getPage = Page::with('module')->whereRaw("TRIM(LOWER(link))=TRIM(LOWER(?))", [$namePage])->first();
        if (isset($getPage))
        {
            $notif->module_id = $getPage->module->module_id ?? $getPage->module_id;
        }
        $notif->save();

        $notifPermUser  = new NotifPermUser();
        $notifPermUser->notif_id = $notif->id;
        $notifPermUser->permission_id = optional(Permission::where('name', "creation-{$generateLink}")->first())->id ?? 1;
        $notifPermUser->user_id = $user->id;
        $notifPermUser->save();

        $eventNotif = new SendNotifEvent($notifPermUser);
        event($eventNotif);

        self::publishEvent(['type' => $generateLink, 'add' => true]);

        // Sending the email conaining the report
        $pdf = PDF::loadView('pdfs.report-uploadfile-item', array(
            'reports'       => $report,
            'user'          => $user,
            'title'         => 'Rapport de l\'import du fichier ' . $importOf,
            'totals'        => [
            'toUpload'     => $totalToUpload,
            'upload'       => $totalUpload,
            ],
            'addToData' => array('entete' => null, 'hidefooter' => true)
        ));

        Log::debug("DANS > " . __CLASS__ . " > " . __FUNCTION__);

        //$user->email = "sakhewar7@gmail.com" ;

        $user->notify(new EndUploadExcelFileNotification($pdf, $importOf));
    }

    // Publish the event on the channel for RealTime
    public static function publishEvent($data)
    {
        $eventRT = new RtEvent($data);
        event($eventRT);
    }

    public static function addWhereToModel(&$query, $args, $filtres)
    {
        foreach ($filtres as $key => $value)
        {
            if (isset($args[$value[0]]) || ($value[1]=='date' && isset($args[$value[0].'_start'])))
            {
                $operator = $value[1];
                $valueColumn = isset($args[$value[0]]) ? $args[$value[0]] : null;
                if ($operator == 'join')
                {
                    $second = $value[2];
                    $query->whereRaw("{$second}_id in (select id from {$second}s where {$value[0]}=?)", [$valueColumn]);
                }
                else if ($operator == 'date')
                {
                    if (isset($args[$value[0].'_start']) && isset($args[$value[0].'_end']))
                    {
                        // Si la colonne est précisée, on utilise la colonne, sinon, on match avec la colonne date
                        $column = isset($value[2]) ? $value[2] : "date";

                        $from = $args[$value[0].'_start'];
                        $to = $args[$value[0].'_end'];

                        //dd($to);
                        // Eventuellement la date fr
                        $from = (strpos($from, '/') !== false) ? Carbon::createFromFormat('d/m/Y', $from)->format('Y-m-d') : $from;
                        $to = (strpos($to, '/') !== false) ? Carbon::createFromFormat('d/m/Y', $to)->format('Y-m-d') : $to;

                        $from = date($from.' 00:00:00');
                        $to = date($to.' 23:59:59');
                        $query->whereBetween($column, array($from, $to));
                    }
                }
                else
                {
                    if ($operator == 'like')
                    {
                        $operator = self::getOperateurLikeDB();
                        $valueColumn = '%' . $valueColumn . '%';
                    }
                    $query->where($value[0], $operator, $valueColumn);
                }
            }
        }
    }


    //Test si le mode de paiement contient au moins un mode de paiement cash
    public static function contientModePaiementCash($items)
    {
        $retour = false;
        if (count($items) > 0) {
            foreach ($items as $key => $value) {
                $mode_paiement_id = $value["mode_paiement_id"];
                $test = ModePaiement::where("id", $mode_paiement_id)->where("paiement_cash", 1)->first();
                if (isset($test)) {
                    $retour = true;
                    return $retour;
                }
            }
        }
        return $retour;
    }


    public static function hasOnePermissionOf(array $models)
    {
        $getAllPermissionsOf = [];
        if (count($models) > 0) {
            $getAllPermissionsOf = Permission::whereNotNull('display_name');
            $getAllPermissionsOf->where(function ($query) use ($models) {
                foreach ($models as $model) {
                    $query->orWhere('name', self::getOperateurLikeDB(), "%{$model}%");
                }
            });
            $getAllPermissionsOf = $getAllPermissionsOf->pluck('name');
        }

        $is_authorize = count($getAllPermissionsOf) == 0;
        foreach ($getAllPermissionsOf as $permissionOf) {
            if (auth()->user()->can($permissionOf)) {
                $is_authorize = true;
                break;
            }
        }
        return $is_authorize;
        //retur
    }

    //Si on est en base test pas
    public static function getCurrentEnv()
    {
        $retour = "local";
        if (config('app.env') === 'production')
        {
            $retour = "prod";
            if (config('app.debug') === true)
            {
                $retour = "test";
            }
        }
        return $retour;
    }
    // ********************************************************** //
    // ********** THIS SECTION IS JUST FOR THIS PROJECT ***esc****** //
    // ********************************************************** //

    public static $queries = array(

        "roles"                       => "id,name,guard_name,permissions{id,name,display_name,guard_name}",

        "pays"                       =>"id,nom,cedeao",

        "fonctionnalites"             =>"id,nom,description,version",

        "mesures"                     =>"nom,description",
        "gravites"                     =>"nom,description",

        
        "users"                       => "id,name,email,image",

        "modepaiements"               => "id,nom,description",

        "modalitepaiements"           => "id,nom,description,nbre_jour",

        "banques"                     => "id,nom,description",

        "devises"                     => "id,nom,signe,cours,unite,precision,taux_change,devise_base",

        "typecotations"               => "id,nom,description,nbre_sous_type_cotation",

        "preferences"                 =>  "id,display_name,valeur,nom",

        "soustypecotations"           => "id,nom,description,type_cotation_id,type_cotation{id,nom}",

        "typeexpeditions"             => "id,nom,description",

        "uniteprestations"            =>  "id,nom,abreviation,description",

        "typeprestations"             => "id,nom,description",

        "prestations"                 => "id,nom,description,type_prestation_id,type_prestation{id,nom}",

        "typeprestataires"            => "id,nom,description,nbre_prestataire",

        "prestataires"               => "id,code,nom,faxe,fixe,ninea,rcc,adresse_postale,status,status_fr,color_status,adresse_geographique,description,type_prestataire_id,type_prestataire{id,nom},telephone,email,modalite_paiement_id,modalite_paiement{id,nom},contacts{id,nom,telephone,email}",

        "typeclients"                => "id,nom,description,nbre_client",

        "personnels"                => "id,nom,prenom,date_naissance,lieu_naissance,telephone,email,adresse,role_id,role{id,name},anciennete,date_embauche,nomcp,emailcp,telephonecp,fonction,pointages{id,personnel_id,date_debut,date_fin,date_debut_fr,date_fin_fr,temps_au_bureau,details_pointages{id,heure_arrive,heure_depart,retard,absence,justificatif,description}}",

        "detailspointages"          => "id,personnel{id,nom,prenom},pointage{id,personnel_id,temps_au_bureau,date_debut,date_debut_fr,date_fin,date_fin_fr},date_debut,date_fin,date,heure_arrive,heure_depart,retard,absence,justificatif,description",

        "priorites"                  => "id,nom,description",

        "tags"                       => "id,nom,description",

        "bilantaches"               => "personnel{id,nom,prenom},tacheprojet{id,personnel_id,duree,status,date_debut,date_fin,nom_tache}",

        "pointages"                  => "id,total_temps_au_bureau,temps_au_bureau,temps_retard,total_temps_retard,date_debut,date_fin,heure_arrive,heure_depart,description,personnel_id,personnel{id,nom,prenom},retard,justificatif",

        "details_pointages"              => "pointage_id,date_debut,date_fin,temps_au_bureau,personnel_id,personnel{id,nom,prenom},details{heure_arrive,heure_depart,description,retard,absence,justificatif}}",

        "evenements"                       => "id,date,mesure,gravite,personnel_id,personnel{id,nom,prenom},projet_id,projet{id,nom},temps,observation,positif_negatif",

        "noyauxinternes"                => "id,nom,description",

        "motifentresortiecaisses"       => "id,nom,description",

        "caisses"                       => "id,nom,description",

        "contacts"                       => "id,nom,prenom,telephone,email",

        "entresortiecaisses"            => "id,caisse_id,caisse{id,nom},motifentresortiecaisse_id,motifentresortiecaisse{id,nom},montant,description",


        "typetaches"                 => "id,nom,description,nbre_tache",

        "categoriedepenses"           => "id,nom,description,nbre_depense",

        "typedepenses"                => "id,nom,description,categorie_depense{id,nom},nbre_depense",

        "typeprojets"                => "id,nom,description,nbre_projet",

        "projets"                     => "code,nom,type_projet{id,nom},client_id,client{id,nom},date_debut,date_cloture",

        "tacheprojets"                => "id,projet{id,nom},personnel{id,nom,prenom},nom_tache,description,duree,duree_convertie,priorite{id,nom},status,date_debut,date_debut_fr,date_fin_fr,date_fin,date_debut2,date_fin2,",

        "secteuractivites"           => "id,nom,description,nbre_client",

        "nomenclatureclients"        => "id,nom,description,nbre_client",

        "clients"                    => "id,code,nom,faxe,fixe,ninea,rcc,adresse_postale,status,status_fr,color_status,adresse_geographique,description,type_client_id,type_client{id,nom},telephone,email,modalite_paiement_id,modalite_paiement{id,nom},nomenclature_client{nom},contacts{id,nom,telephone,email}",

        "marques"                    => "id,nom,description",

        "canals"                    => "id,nom,description",
        "canalslacks"                    => "id,nom,slack_id",

        "departements"                  =>"id,mage,nom,description",

        "depenses"                    => "id,nom,montant,description,typedepense{id,nom}",

        "modeles"                    => "id,nom,description",

        "livreurs"                   => "id,code,nom,faxe,fixe,ninea,rcc,adresse_postale,status,status_fr,color_status,adresse_geographique,description,telephone,email,contacts{id,nom,telephone,email}",

        "marchandises"               => "id,nom,reference,nomenclature_douaniere_id,nomenclature_douaniere{id,nom},type_marchandise_id,type_marchandise{id,nom},marque{id,nom},modele_id,modele{id,nom},energie_id,energie{id,nom},description",

        "vehicules"                  => "id,nom,immatriculation,nomenclature_douaniere_id,nomenclature_douaniere{id,nom},marque_id,marque{id,nom},modele_id,modele{id,nom},energie_id,energie{id,nom},description",

        "typeentrepots"              => "id,nom,description",

        "entrepots"                  => "id,nom,num_id_douaniere,description,type_entrepot_id,type_entrepot{id,nom},appartenance,status,status_fr,color_status",

        "typedossiers"               => "id,nom,description",

        "dossiers"                   => "id,date,date_fr,type_dossier_id,type_dossier{id,nom},client_id,client{id,nom}",

        "dossiernotedetails"         => "id,dossier{devise_ass_nd_id,devise_fret_nd_id,regime_nd{code},navire_nd,numero_connaissement},designation,nb_colis,article_id,nomenclature_douaniere_id,show_qte_complementaire,label_qte_complementaire,qte_complementaire,article{nom},nomenclature_douaniere{code,unite_mesure{abreviation},valeur_mercurial},origine_id,show_option_cedeao,numero_facture,nom_fournisseur,matricule_fournisseur,code_produit,origine{nom},provenance_id,provenance{nom},poids_brut,poids_net,numero_dpi,valeur,devise_id,devise{nom},valeur_assurance,valeur_fret,valeur_ajustement,valeur_caf,valeur_mercuriale,quantite",

        "fournisseurs"               => "id,code,nom,prenom,faxe,fixe,ninea,rcc,adresse_postale,status,status_fr,color_status,adresse_geographique,description,telephone,email,contacts{id,nom,telephone,email}",

        "taxedouanieres"             => "id,code,nom,taux,famille_taxe_douaniere{nom},details{nom},comptant",

        "nomenclaturedouanieres"     => "id,nom,description,taxe_douanieres{id,nom}",

        "typemarchandises"           => "id,nom,description",

        "chapitrenomenclaturedouanieres"           => "id,code,nom",

        "ordretransits"             => "id,type_dossier_id,client_id,type_importation_id,type_marchandise_id,nomenclature_asuivre_id,nomenclature_asuivre_fr,indication,type_marchandise{nom},type_dossiers{nom},code,numero_interne,numero_conteneur,numero_client,niveau_habilite_id,isAllDocsCorrect,bls_ordretransit_iscorrect,ffs_ordretransit_iscorrect,ffts_ordretransit_iscorrect,asres_ordretransit_iscorrect,dpis_ordretransit_iscorrect,bscs_ordretransit_iscorrect,is_complet,date,date_fr,date_depart,date_depart_fr,date_arrivee,date_arrivee_fr,navire,exo_tva,type_dossier{nom,couleurbg,couleurfg,bgStyle,fgStyle,nbre_type_dossier,details{couleurbg}},type_importation{nom,description,show_container},client{id,nom,display_text},niveau_habilite_id,niveau_habilite{id,nom},status,status_fr,color_status,marchandises{id,show_indication,indication,nomenclature_asuivre_id,quantite,numero_chassis,show_exo,exo_tva,poids,marchandise_id,marchandise{nom,code_vehicule,marque{nom},modele{nom},energie{nom},cylindre},nom,fgStyle,bgStyle,unite_mesure_id,unite_mesure{nom},type_dossier_id,type_dossier{nom,nbre_type_dossier,bgStyle},nomenclature_douaniere_id},conteneurs{id,quantite,type_conteneur_id,type_conteneur{nom},numero},documents{id,nom,numero,files{id,name,identify,url}},files{id,name,identify,url},bls{id,numero,type_id,files{id,name,identify,url}},ffs{id,num,inclut_fret,montant,devise_id,devise{id,nom},inclut_fret,files{id,name,identify,url}},ffts{id,num,montant,devise_id,devise{id,nom},files{id,name,identify,url}},asres{id,type_id,devise_id,devise{nom},montant,num,file_required,show_others,files{id,name,identify,url}},dpis{id,type_id,num,file_required,show_others,choose_debour,debour_id,files{id,name,identify,url}},bscs{id,type_id,num,file_required,show_others,choose_debour,debour_id,files{id,name,identify,url}},files{id,name,identify,url}",

        "niveauhabilites"           => "id,nom,niveau",

        "ports"                    => "id,nom,description",

        "navires"                  => "id,nom",

        "unitemesures"             => "id,nom,abreviation",

        "bureaus"                  => "id,code,nom",

        "energies"                => "id,nom,description",

        "familledebours"          => "id,code,nom",

        "regimes"                 => "id,code,nom,type_dossier{nom}",

        "articlefacturations"     => "id,code,nom,famille_debour{nom}",

        "typeconteneurs"          => "id,nom,description",

        "familletaxedouanieres"   => "id,code,nom,nbre_familletaxedouaniere",

        "typeimportations"        => "id,nom,type_marchandises{nom},type_dossiers{nom},description",
        "assistances"             => "id,display_text,code,status,status_fr,color_status,detail,type_tache_id,rapporteur,date_fr,date,projet_id,projet{id,nom},tag_id,tag{id,nom},canal_id,canal{id,nom},collecteur_id,collecteur{id,name},assigne_id,assigne{id,name}",
        "demandeabsences"         => "id,date,heure_debut,heure_fin,date_fr,date_fin,date_fin_fr,date_debut,date_debut_fr,description,motif,employe_id,employe{id,nom,display_text},status",
        "avancesalaires"          => "id,date,date_fr,montant,status,etat,employe_id,employe{id,nom,display_text},remboursements{id,date,date_fr,restant,montant_total}",
        "rapportassistances"      => "id,date,date_fr,libelle,description,status,projet_id,projet{id,nom},details_assistance{id,rapport_assistance_id,assistance_id,assistance{id,date_fr,duree,rapporteur,canal_id,tag_id,type_tache_id,type_tache{id,nom},collecteur_id,assigne_id,tag{id,nom},display_text,code,status,status_fr,color_status,detail,projet{id,nom,display_text},canal{id,nom},collecteur{id,name,display_text},assigne{id,name,display_text}}}",
        "projetprospects"         => "id,date,date_fr,client_id,nom,client{id,display_text},commentaires,status,noyaux_interne_id,noyaux_interne{id,nom,display_text}",
        "surmesures"              => "id,date,date_fr,client_id,nom,commentaires,client{id,display_text},status",
    );

    public static function restrictionUser(&$query, $prefixColumn = "point_vente", $foreignColumn = null, $likeForeignKey = false, $currentUserId = null,$is_depense=false)
    {
        $currentUserId = isset($currentUserId) ? $currentUserId : Auth::user()->id;
        $fromColumn = (!$likeForeignKey ? "" : $prefixColumn . "_") . "id";
        $prefixColumn =  $prefixColumn=="caisse_destinataire" ?'caisse':$prefixColumn;
        $foreignColumn = (isset($foreignColumn) ? $foreignColumn : $prefixColumn);
        $query->whereRaw(" ({$fromColumn} IN ( select {$prefixColumn}_id from user_{$foreignColumn}s where user_id = ? ) OR (select count(*) from user_{$foreignColumn}s where user_id = ? ) = 0) ", [$currentUserId, $currentUserId]);
    }

    public static function restrictionNiveauHabilitation(&$query,  $currentNiveauId , $prefixColumn ='niveau_habilitation_id' )
    {
        $currentNiveau = NiveauHabilitation::find($currentNiveauId);
        if(isset( $currentNiveau))
        {
            $query->whereIn('niveau_habilitation_id', NiveauHabilitation::where('niveau','<=',$currentNiveau->niveau)->get('id'))->orWhereNull('niveau_habilitation_id');
        }
    }

    //Donne les caisses accessibles par l'utilisateur
    public static function donneAllCaissesUser($user_id = null)
    {
        if(empty($user_id))
        {
            $user_id = Outil::donneUserId();
        }

        $retour = UserCaisse::where('user_id', $user_id)->get(['caisse_id']);
        if (count($retour) == 0)
        {
            $retour = Caisse::where('id','>',0)->get(['id']);
        }
        return $retour;
    }

    //Donne la première caisse de l'utilisateur
    public static function donneCaisseUser($user_id = null)
    {
        if(empty($user_id))
        {
            $user_id = Outil::donneUserId();
        }

        $retour = null;
        $user_caisse = UserCaisse::where('user_id', $user_id)->first();
        if (isset($user_caisse)) {
            $retour = $user_caisse->caisse_id;
        }
        return $retour;
    }

    //Test si le billetage correspond aux encaissements
    public static function testBilletage($billetages, $encaissements)
    {
        $retour = true;
        if (count($billetages) > 0 && count($encaissements) > 0) {
            $sommeBilletages = 0;
            $sommeEncaissements = 0;

            foreach ($billetages as $key => $value) {
                $typebillet_id = $value["typebillet_id"];
                $test = TypeBillet::find($typebillet_id);
                if (isset($test)) {
                    $sommeBilletages += $value["nombre"] * $test->valeur;
                }
            }

            foreach ($encaissements as $key2 => $value2) {
                $mode_paiement_id = $value2["mode_paiement_id"];
                $test = ModePaiement::where("id", $mode_paiement_id)->where("paiement_cash", 1)->first();
                if (isset($test)) {
                    $sommeEncaissements += $value2["montant"];
                }
            }

            if ($sommeBilletages != $sommeEncaissements) {
                $retour = false;
            }
            //dd("sommeBilletages".$sommeBilletages." / sommeEncaissements".$sommeEncaissements);
        }
        return $retour;
    }

    //Test si l'utilisateur doit voir l'élément ou pas
    public static function canSeeItemUser($type = "entite")
    {
        $retour = true;
        $nbre = 0;
        $user_id = Outil::donneUserId();

        if($type == "entite")
        {
            $nbre = UserPointVente::where('user_id', $user_id)->count();
        }
        else if($type == "caisse")
        {
            $nbre = UserCaisse::where('user_id', $user_id)->count();
        }
        if ($nbre == 1)
        {
            $retour = false;
        }

        return $retour;
    }

    public static function isAuthorize($currentUser = true, $userId = null)
    {
        //Récupration utilisateur
        if ($currentUser)
        {
            $user = Auth::user();
            if(empty($user))
            {
                $user = User::where('email', 'guindytechnology@gmail.com')->first();
            }
        }
        else
        {
            $user = User::find($userId);
        }

        //Test
        if ($user->can(self::getPermissionTypeTransaction2()))
        {
            $retour = 2;
        }
        else if ($user->can(self::getPermissionTypeTransaction()))
        {
            $retour = 1;
        }
        else
        {
            $retour = 0;
        }

        return $retour;
    }

    public static function getPermissionTypeTransaction()
    {
        return config('env.PERMISSION_TRANSACTION');
    }

    public static function getPermissionTypeTransaction2()
    {
        return config('env.PERMISSION_TRANSACTION2');
    }

    //Donne l' item  de l'utilisateur
    public static function giveItemUser($type = "entite", $item_id, $etat = null)
    {
        $test = Outil::canSeeItemUser($type);
        $user_id = Outil::donneUserId();

        if($test == false)
        {
            //il n'a qu'un élément
            if($type == "entite")
            {
                $item_id = UserPointVente::where('user_id', $user_id)->first()->point_vente_id;
            }
            else if($type == "caisse")
            {
                $item_id = UserCaisse::where('user_id', $user_id)->first()->caisse_id;
            }

        }
        if($type == "departement")
        {
            $item_id = isset($etat) && $etat == true ? UserDepartement::where('user_id', $user_id)
                ->where('etat', $etat)
                ->where('departement_id', $item_id)
                ->first()
                : UserDepartement::where('user_id', $user_id)->first();
        }

        return $item_id;
    }

    //Donne l'id de l'utilisateur actuellement connecté
    public static function donneUserId()
    {
        $user = Auth::user();
        $retour = isset($user) ? Auth::user()->id : null;
        return $retour;
    }

    public static function voirDepenseTrancheHoraireEnCours($currentUser = true, $userId = null)
    {
        $retour = 0;
        if ($currentUser)
        {
            $userId = Outil::donneUserId();
        }

        $user = User::find($userId);
        if(isset($user))
        {
            if ($user->can('voir-depense-tranche-horaire'))
            {
                $retour = 1;
            }
        }

        return $retour;
    }

    public static function donneTrancheHoraire($heure = null)
    {
        if (empty($heure)) {
            $heure = date('H:i');
        }
        $retour = TrancheHoraire::where('heure_debut', '<=', $heure)->where('heure_fin', '>=', $heure)->first();
        if (empty($retour)) {
            $retour = null;
        }
        return $retour;
    }

   public static function getDateEng($date, $format = null)
   {
       $date_at = $date;
       if(!isset($format)){
           $format = 'Y-m-d';
       }

       if ($date_at !== null) {
           $date_at = $date_at;
           $date_at = date_create($date_at);
           return date_format($date_at, $format);
       } else {
            return '';
       }
   }


    public static function generateCode($id)
    {
        $count = "";
        $id = intval($id);
        if ($id <= 9) {
            $count = "000" . $id;
        } else if ($id >= 10 && $id <= 99) {
            $count = "00" . $id;
        } else if ($id >= 100 && $id <= 999) {
            $count = "0" . $id;
        } else if ($id > 999) {
            $count = $id;
        } else {
            $count = $id;
        }

        return $count;
    }

    public static function getCode($model, $indicatif)
    {
        $getLast = app($model)::where('code', self::getOperateurLikeDB(), '%' . $indicatif . '%')->orderBy('id', 'desc')->first();
        $codenumber = 1;
        if (isset($getLast))
        {
            $codenumber = $getLast->id + 1;
        }
        $code  =  $indicatif . "-00" . $codenumber . '-' . date('y');

        $sim = app($model)::where('code', $code)->orderBy('id', 'desc')->first();
        if (isset($sim))
        {
            $codenumber = $sim->id + 1;

            $cpt = 0;
            while (isset($sim))
            {
                $code = $indicatif . "-00" . $codenumber . '-' . date('y');
                $sim = app($model)::where('code', $code)->orderBy('id', 'desc')->first();
                $codenumber++;
                $cpt++;
                // if ($cpt==20)
                // {
                //     dd($codenumber, $sim);
                // }
            }
        }

        return $code;
    }

    // public static function getCode($item,  $indicatif = null)
    // {
    //     $dateCode = '';
    //     $dateCode = self::getDateEng(now(),'Y-m-d');
    //     $dateCode = str_replace('-','',$dateCode);
    //     $code = $indicatif. '-' . $dateCode . '' . self::generateCode($item->id);
    //     $item->code = $code;
    //     // dd($item);
    //     $item->save();
    // }

    public static function getCode2point0($item, $date = null)
    {
        $model = self::getQueryNameOfModel($item->getTable());
        $dateCode = '';

        if ($date) {
            $dateCode = self::getDateEng($date);
        } else {
            $dateCode = self::getDateEng(now());
        }
        $dateCode = str_replace('-','',$dateCode);

        if(strtolower(class_basename($model)) == 'factures')
        {
            $code = self::getCodeFacture($item);
        }
        else if(strtolower(class_basename($model)) == 'bonentrees')
        {

            $code = self::getCodeFacture($item, 'be');
        }
        else if(strtolower(class_basename($model)) == 'bcis')
        {
            $code = self::getCodeFacture($item, 'bci');
        }
        else if(strtolower(class_basename($model)) == 'commandes')
        {
            $code = self::getCodeCommande($item);
        }
        else if(strtolower(class_basename($model)) == 'reservations')
        {
            $code = self::getCodeReservation($item);
        }
        else if(strtolower(class_basename($model)) == 'proformas')
        {

            $code = 'P'.self::getSiglleEntite($item) . '-' . $dateCode . '' . self::generateCode($item->id);
        }
        else
        {
            $code = self::generateIndicatif($model) . '-' . $dateCode . '' . self::generateCode($item->id);
        }

        $item->code = $code;
        $item->save();
        return $code;
    }

    public static function generateIndicatif($model)
    {

        $modelName = class_basename($model);
        $alias = '';
        if (strtolower($modelName) == 'produits') {
            $alias = 'PRD';

        }
        if (strtolower($modelName) == 'clients') {
            $alias = 'CLI';
        }
        if (strtolower($modelName) == 'depots') {
            $alias = 'DPO';
        }
        if (strtolower($modelName) == 'commandes') {
            $alias = 'CMD';
        }
        if (strtolower($modelName) == 'departements') {
            $alias = 'DPT';
        }
        if (strtolower($modelName) == 'fournisseurs') {
            $alias = 'FRS';
        }
        if (strtolower($modelName) == 'bcis') {
            $alias = 'BCI';
        }

        if (strtolower($modelName) == 'bces') {
            $alias = 'BCE';
        }

        if (strtolower($modelName) == 'bon_entrees') {
            $alias = 'BEN';
        }

        if (strtolower($modelName) == 'actions') {
            $alias = 'ACT';
        }

        if (strtolower($modelName) == 'proformas') {
            $alias = 'PRF';
        }
        if (strtolower($modelName) == 'bts') {
            $alias = 'BTS';
        }
        if (strtolower($modelName) == 'depenses') {
            $alias = 'DEP';
        }
        if (strtolower($modelName) == 'factures') {
            $alias = 'FAC';
        }

        if (strtolower($modelName) == 'assemblages') {
            $alias = 'ASS';
        }
        if (strtolower($modelName) == 'cloture_caisses' || strtolower($modelName) == 'cloturecaisses') {
            $alias = 'CTC';
        }

        return $alias;
    }

    public static function  getCodeFacture($item, $type = 'facture')
    {
        $alias = 'F';
        $aliasSocFac = '';
       // $dateCode = date('Ymd');
        $dateCode = isset($item->date) ? self::resolveDateCodeFacture($item->date) :  date('Ymd');
        $code     = '';
        if($type  ==  'facture'){
            if($item->compta >= 1)
            {
                $alias = 'N';
            }
            if(isset($item->societe_facturation_id))
            {
                $societefacturation = Societefacturation::find($item->societe_facturation_id);
                if(isset($societefacturation))
                {
                    $aliasSocFac = $societefacturation->alias;
                }
            }

            $code        = $alias . $aliasSocFac;
        }
        else if($type    == 'be')
        {
            $code        = 'BE';
        }
        else if($type    == 'bci')
        {
            $dateCode    = isset($item->date_operation) ? self::resolveDateCodeFacture($item->date_operation) :  date('Ymd');
            $code        = 'BCI';

            if(isset($item->entite_id)){
                $entite  = Entite::find($item->entite_id);
                $code    = $code . $entite->alias;
            }
        }

        $code = $code . $dateCode . '-' . self::generateCode($item->codification);

       // dd($code);
        return $code;
    }

    public static function resolveDateCodeFacture($date)
    {
        $date_at = $date;
        $date_at = $date_at;
        $date_at = date_create($date_at);
        return date_format($date_at, "Ymd");
    }

    public static function donneCodification($type = 'facture', $item)
    {
        $retour = 0;
        if($type == 'facture')
        {
            if($item->compta == 0)
            {
                $retour = Facture::where('date', $item->date)->where('compta', $item->compta)->where('societe_facturation_id', $item->societe_facturation_id)->max('codification');
            }
            else
            {
                $retour = Facture::where('date', $item->date)->where('compta', '>=', 1)->where('societe_facturation_id', $item->societe_facturation_id)->max('codification');
            }
        }else if($type == 'be'){
            $retour = BonEntree::where('date', $item->date)->max('codification');
        }
        else if($type == 'bci'){
            $retour     = Bci::where('date_operation', $item->date_operation);
            if(isset($item->entite_id)){
                $retour = $retour->where('entite_id', $item->entite_id);
            }
            $retour     = $retour->max('codification');
        }

        if(empty($retour))
        {
            $retour = 0;
        }
        $retour += 1;
        return $retour;
    }

    // public static function getCode($model, $indicatif)
    // {
    //     $getLast = app($model)::where('code', self::getOperateurLikeDB(), '%' . $indicatif . '%')->orderBy('id', 'desc')->first();
    //     $codenumber = 1;
    //     if (isset($getLast))
    //     {
    //         $codenumber += $getLast->id + 1;
    //     }
    //     $code  =  $indicatif . "-00" . $codenumber . '-' . date('y');
    //     return $code;
    // }


    //Donne date par rapport à l'ajout de nombre de jours
    public static function donneDateParRapportNombreJour($madate, $nbre)
    {
        $retour = date("Y-m-d", strtotime(date($madate) . " +$nbre days"));
        return $retour;
    }

    //Nomnre de jours entre 2 dates
    public static function nombreJoursEntreDeuxDates($date_debut, $date_fin)
    {
        $date_debut = strtotime($date_debut);
        $date_fin = strtotime($date_fin);
        $retour = round(($date_fin - $date_debut)/60/60/24,0);
        return $retour;
    }

    public static function filterByTrancheHoraires($parametres)
    {

        $query              = $parametres["query"];
        $dateStart          = $parametres["dateStart"];
        $dateEnd            = $parametres["dateEnd"];
        $tranche_horaires   = $parametres["tranche_horaires"];
        $table              = $parametres["table"];
        $columnDateName     = $parametres["columnDateName"];

        $tranche_horaires = str_replace("'", '"', $tranche_horaires);
        $tranche_horaires = json_decode($tranche_horaires, true);


        foreach ($tranche_horaires as $one)
        {

            //Mettre ici toutes les dates qui seront compris entre le debut et la fin et faire un ForEach
            $trancheHoraire = TrancheHoraire::find($one);
            if(isset($trancheHoraire))
            {

                $heure_debut = $trancheHoraire->heure_debut;
                $heure_fin = $trancheHoraire->heure_fin;
                $nbreJours = Outil::nombreJoursEntreDeuxDates($dateStart, $dateEnd);
                for($i = 0; $i <= $nbreJours; $i++)
                {
                    $dateOne = Outil::donneDateParRapportNombreJour($dateStart, $i);
                    $dateOneStart = $dateOne . " " .$heure_debut;
                    $dateOneEnd = $dateOne . " " .$heure_fin;

                    if($heure_debut > $heure_fin)
                    {
                        $dateOneTmp = Outil::donneDateParRapportNombreJour($dateStart, 1);
                        $dateOneEnd = $dateOneTmp . " " .$heure_fin;
                    }

                    $query = $query->where(function ($query) use ($table,$columnDateName,$dateOneStart, $dateOneEnd)
                    {
                        return $query->where($table.'.id', '>' ,0)
                        ->orWhereBetween($table.'.'.$columnDateName, [$dateOneStart, $dateOneEnd]);
                    });

                }
               // dd($query->get());
            }
        }
        //dd($tranche_horaires);
        return $query;
    }

    public static function testPlanning($items)
    {
        $errors = null;
        if (empty($items))
        {
            $errors = "Veuillez remplir tout le tableau";
        }
        else
        {
            $items                         = json_decode(($items),true) ;

            foreach ($items as $depkey => $value)
            {
                if (empty($value['departement_rh_id']))
                {
                    $errors = "L'id du département n°: " . ($depkey+1)  . " n'est pas défini";
                    break;
                }
                $employes = $value['employes'] ?? [];
                foreach ($employes as $empkey =>$value2)
                {

                    if (empty($value2['employe_id']))
                    {
                        $errors = "L'id de l'employé n°: " . ($empkey+1) . " n'est pas défini";
                        break;
                    }

                    $jours = $value2['jours'] ;
                    foreach ($jours as $jrkey=>$value3)
                    {
                        if (empty($value3['id']))
                        {
                            $errors = "L'id du jour n°: " . ($jrkey+1 ). " n'est pas défini";
                            break;
                        }
                        if (empty($value3['shift_id']))
                        {
                            $errors = "le shift n'est pas défini (référence: département n°: " . ($depkey+1 ). " / employé n°: " . ($empkey+1) . " / jour n°: " .( $jrkey+1 ). ")";
                            break;
                        }
                        if (empty($value3['tranche_horaire_id']))
                        {
                            $errors = "La tranche horaire n'est pas définie (référence: département n°: " .($depkey+1 ) . " / employé n°: " . ($empkey+1) . " / jour n°: " . ( $jrkey+1 ) . ")";
                            break;
                        }
                    }
                }
            }

        }
        return $errors;
    }
    public static function getAllItemsWithGraphQl($queryName, $filter = null, $attribus = null)
    {

        self::setParametersExecution();
        $critere = isset($filter) ? '(' . $filter . ')' : "";
        $guzzleClient = new \GuzzleHttp\Client();
        $queryAttr = isset($attribus) ? $attribus : Outil::$queries[$queryName];
        $queries = $queryName . $critere;

        $url = self::getAPI() . "graphql?query={{$queries}{{$queryAttr}}}";

        //dd($url);
        $response = $guzzleClient->request('GET', $url, self::$guzzleOptions);
        $data = json_decode($response->getBody(), true);
       //dd($data);

        return $data['data'][$queryName];
    }

    //Donne la date avec heure, minute, seconde en anglais
    public static function donneDateCompletEn($date, $avecSeconde = true)
    {
        $date_at = $date;
        if($date_at !== null)
        {
            $date_at = str_replace("T"," ",$date_at);
            $date_at = date_create($date_at);
            if ($avecSeconde == false) {
                $date_at = date_format($date_at, "Y-m-d");
            } else {
                $date_at = date_format($date_at, "Y-m-d H:i:s");
            }
            //dd($date_at);
            return $date_at;

        } else {
            return null;
        }
    }

    public static function ca_commande_menu($date_debut, $date_fin, $type = null, $id_type = null, $itemArray =null, $offre = null, $perte = null, $conso_interne = null, $client_id = null){

            $commandeProduit_menu  = CommandeProduit::query()
                ->whereNotNull('commande_produits.commande_produit_id')
                ->join('produits', 'produits.id', '=', 'commande_produits.produit_id')
                ->join('commandes', 'commandes.id', '=', 'commande_produits.commande_id')
                ->whereBetween('commandes.date', [$date_debut, $date_fin]);

        if(isset($client_id)) {
            if (isset($client_id)) {
                $commandeProduit_menu = $commandeProduit_menu->where('commandes.client_id', $client_id);
            }
        }

        if(isset($conso_interne) && $conso_interne == 1){

            $commandeProduit_menu =   $commandeProduit_menu->whereIn('commandes.c_interne', [1,2]);
        }else{
            if(isset($conso_interne) && $conso_interne == 2){
                $commandeProduit_menu =   $commandeProduit_menu->where('commandes.c_interne', 2);
            }else{
                $commandeProduit_menu =   $commandeProduit_menu->where('commandes.c_interne', '!=', 1);
            }

        }

        if($offre){
            $commandeProduit_menu  = $commandeProduit_menu->where('commande_produits.offert', ($offre == true ? 1 : 0));
        }else if($offre == false){
            $commandeProduit_menu  = $commandeProduit_menu->whereNull('commande_produits.offert');
        }

        if(isset($perte) && $perte == true){
            $commandeProduit_menu  = $commandeProduit_menu->where('commande_produits.perte', $perte);
        }else if($perte == null){
            $commandeProduit_menu  = $commandeProduit_menu->whereNull('commande_produits.perte');
        }

         if(isset($type)){
            $commandeProduit_menu =   $commandeProduit_menu->where('commandes.type_commande_id', $id_type);
        }

         if(isset($itemArray)){
             $commandeProduit_menu = Outil::rajouteElements($commandeProduit_menu, $itemArray, 'commande_produits');
         }

        $commandeProduit_menu = $commandeProduit_menu->
        selectRaw('COALESCE(SUM(commande_produits.prix),0) as total, count(produits.id) as nombre, commande_produits.produit_id as menu_id')
            ->whereNotNull('commande_produits.commande_produit_id')
            ->groupBy(['produits.id','commande_produits.produit_id'])
            ->get();
        $montant_menu = 0;

        if(isset($commandeProduit_menu) && count($commandeProduit_menu) > 0){
            foreach ($commandeProduit_menu as $value)
            {
                $produit = Produit::find($value->menu_id);
                if(isset($produit))
                {
                    $montant_menu +=$value->total;
                }
            }

            //   dd($retour);
        }

        return $montant_menu;
    }

     public static function dateEnFrancais($date)
    {
        $date_at = $date;
        $date_at = $date_at;
        $date_at = date_create($date_at);
        return date_format($date_at, "d-m-Y");
    }
    //Récupérer les détails des éléments des états
    public static function donneElementsEtat($type = "commande", $itemArray, $query = null,$args = null)
    {
        //dd($type);

        $filtres                = "";
        $typeAvecS              = $type . "s";
        $retour                 = null;
        $date_debut             = null;
        $date_fin               = null;
        $caisse_id              = null;
        $entite_id              = null;
        $fournisseur_id         = null;
        $entites                = null;
        //clocaisse_tranche_multiples
        $tranche_horaires       = null;

        $retourArray = array();


        if(isset($itemArray))
        {
            $date_debut = isset($itemArray["date_debut"]) ? $itemArray["date_debut"] : null;
            $date_fin =  isset($itemArray["date_fin"]) ? $itemArray["date_fin"] : null;
            if ($type == "reglement" || $type == "commande"         || $type == "produits_commandes_non_offerts"
                ||
                $type == "produits_commandes_offerts"               || $type == "ca_commandes_non_offerts"
                ||
                $type == "ca_commandes_offerts"                     || $type == "ca_commandes_liquide_non_offerts"
                ||
                $type == "ca_commandes_liquide_offerts"             || $type == "ca_commandes_solide_non_offerts"
                ||
                $type == "ca_commandes_solide_offerts"              || $type == "elements_caisse"
                ||
                $type == "ca_commandes_sur_place"                   || $type == 'nombre_de_couverts'
                ||
                $type == 'recap_cloture_caisse'                     || $type == 'ca_commandes_a_livrer'
                ||
                $type == 'nombre_livraison'                         || $type == 'ca_commandes_a_emporter'
                ||
                $type == 'nombre_emporter'                          || $type == 'ca_commandes_liquide_pertes'
                ||
                $type == 'ca_commandes_solide_pertes'               || $type =='ca_commandes_solide_offerts'
                ||
                $type == 'ca_commandes_conso_interne')
            {
                $fournisseur_id                         = isset($itemArray["fournisseur_id"]) ? $itemArray["fournisseur_id"] : null;
                $entites                                = isset($itemArray["entites"]) ? $itemArray["entites"] : null;
                //clocaisse_tranche_multiples
                $tranche_horaires                       = isset($itemArray["tranche_horaires"]) ? $itemArray["tranche_horaires"] : null;

                $date_debut = Outil::donneDateCompletEn($date_debut, false);
                $date_fin = Outil::donneDateCompletEn($date_fin, false);
                if((!empty($itemArray["caisse_id"])))
                {
                    $caisse_id = $itemArray["caisse_id"];
                    $caisse  = Caisse::find($caisse_id);
                    if(isset($caisse) && isset($caisse->point_vente_id)){
                        $entite_id  = $caisse->point_vente_id;
                    }

                    //var_dump($entite_id);
                }

                if(isset($query))
                {
                    $retour = $query;
                }

                if((!empty($itemArray["cloture_caisse_id"])))
                {
                    $cloture_caisse_id = $itemArray["cloture_caisse_id"];
                    $cloturecaisse = Cloturecaisse::find($cloture_caisse_id);
                    if(isset($cloturecaisse))
                    {
                        $date_debut = $cloturecaisse->date_debut;
                        $date_fin = $cloturecaisse->date_fin;
                        $caisse_id = $cloturecaisse->caisse_id;
                        $caisse  = Caisse::find($caisse_id);
                        if(isset($caisse) && isset($caisse->point_vente_id)){
                            $entite_id  = $caisse->point_vente_id;
                        }
                    }
                    //var_dump($date_debut . '====' . $date_fin);
                }
                //dd($itemArray["tranche_horaire_id"]);
                if(!empty($itemArray["tranche_horaire_id"]) && isset($itemArray["tranche_horaire_id"]))
                {

                    if(empty($itemArray["cloture_caisse_id"]))
                    {
                        $tranche_horaire = TrancheHoraire::find($itemArray["tranche_horaire_id"]);

                        $heure_debut_tranche = Carbon::parse($tranche_horaire->heure_debut)->format('H:i:s');
                        $heure_fin_tranche = Carbon::parse($tranche_horaire->heure_fin)->format('H:i:s');

                        $paras_heure_debut = explode(' ', $date_debut);
                        $paras_heure_fin   = explode(' ', $date_fin);

                        if(isset($paras_heure_debut) && isset($paras_heure_debut[0]) && isset($paras_heure_fin) && isset($paras_heure_fin[0])){
                            if($heure_debut_tranche > $heure_fin_tranche){
                                if($paras_heure_debut[0] == $paras_heure_fin[0]){
                                    $paras_heure_fin[0] = date('Y-m-d', strtotime($date_fin. ' + 1 days'));
                                }
                            }
                            $date_debut = $paras_heure_debut[0] . ' '. $heure_debut_tranche;
                            $date_fin   = $paras_heure_fin[0] . ' '. $heure_fin_tranche;
                        }

                    }else{

                    }

                }else{

                    $date_debut = $date_debut . ' 00:00:00';
                    $date_fin   = $date_fin . ' 23:59:59';

                }
            }

            if ($type == "reglement")
            {
                if(isset($date_debut) && isset($date_fin))
                {
                    if(isset($query))
                    {
                        $retour = $retour->whereBetween('date', [$date_debut, $date_fin]);
                    }
                }
                if((!empty($caisse_id)))
                {
                    if(isset($query))
                    {
                        $retour = $retour->where('caisse_id', $caisse_id);
                    }
                }
            }

            if ($type == "commande")
            {
                //dd("ici");
                if(isset($date_debut) && isset($date_fin))
                {
                    if(isset($query))
                    {
                        $retour = $retour->whereBetween('commandes.date', [$date_debut, $date_fin]);
                    }
                }
                if((!empty($caisse_id)))
                {
                    if(isset($query))
                    {
                        $caisse = Caisse::find($caisse_id);
                        if(isset($caisse->point_vente_id) && isset($caisse->point_vente_id))
                        {
                            $retour = $retour->where('point_vente_id',$caisse->point_vente_id);
                        }
                        else
                        {
                            $retour = $retour->where('point_vente_id',null);
                        }
                    }
                }
            }

            if ($type == "produits_commandes_non_offerts")
            {
                //dd("ici");
                //Selectionner tous les produits des commandes
                //$mode_paiement_id   = ModePaiement::conso_interne()->id;
                $filterStr          = "commande_produits.offert = 0 and commande_produits.perte is null and commande_produits.commande_produit_id is null and (commandes.date between '$date_debut' and '$date_fin') and commandes.c_interne != 1 ";
                $subQuery           = "(select COALESCE(SUM(commande_produits.prix),0) as total from commande_produits join produits on commande_produits.produit_id = produits.id join commandes on commandes.id = commande_produits.commande_id where $filterStr and produits.famille_produit_id in (WITH RECURSIVE c AS (
                                    SELECT famille_produits.id::bigint AS id
                                    UNION ALL
                                    SELECT famille_produits.id
                                    FROM famille_produits JOIN c ON c.id = famille_produits.parent_famille_id
                                    )
                                    SELECT id FROM c))";

                $query     = FamilleProduit::whereNull('parent_famille_id')
                    ->selectRaw("famille_produits.*, $subQuery as total")
                    ->whereRaw("$subQuery > 0")->orderBy('total','desc')->get();
                $query     = $query->sortBy('total', SORT_REGULAR, 'asc');


                foreach($query as  $key => $famille)
                {
                    $produits                = Commandeproduit::join('produits', 'produits.id', '=', 'commande_produits.produit_id')
                                                                ->join('commandes', 'commandes.id', 'commande_produits.commande_id')
                                                                ->whereRaw("$filterStr")
                                                                ->whereRaw("produits.famille_produit_id in (WITH RECURSIVE c AS (
                                                                SELECT {$famille->id}::bigint AS id
                                                                UNION ALL
                                                                SELECT famille_produits.id
                                                                FROM famille_produits JOIN c ON c.id = famille_produits.parent_famille_id
                                                                )
                                                                SELECT id FROM c)")
                                                                ->selectRaw('commande_produits.*')->get();

                    $query[$key]['produits'] = collect($produits)->groupBy('produit_id')->sortBy('');
                    //dd($query[$key]['produits']);
                }
                //Fin code de jacques
                //Fin code de jacques

                $total_commande_produits = $query->sum('total');

                $query                   = DB::table('commande_produits')
                                            ->join('commandes', 'commandes.id', '=', 'commande_produits.commande_id')
                                            ->where('commande_produits.offert', '=', 0)
                                            ->where('commande_produits.perte',0)
                                            ->whereNull('commande_produits.commande_produit_id')
                                            ->whereBetween('commandes.date', [$date_debut, $date_fin]);

                $query                   = self::sansConsoInterne($query);

                if($entite_id){
                    $itemArray['entite_id']  = $entite_id;
                }

                $query = Outil::rajouteElements($query, $itemArray, 'commande_produits');
                //dd($query->get());
                $query = $query->selectRaw('COALESCE(SUM(commande_produits.prix),0) as total, count(commande_produits.produit_id) as nombre, commande_produits.produit_id')
                ->groupBy('commande_produits.produit_id');
                $query = $query->get();

                //dd($query->sum('total'), $itemArray);

                //Selectionner tous les menus des commandes

                $commandeProduit_menu  = CommandeProduit::query()
                    ->whereNotNull('commande_produits.commande_produit_id')
                    ->join('produits', 'produits.id', '=', 'commande_produits.produit_id')
                    ->join('commandes', 'commandes.id', '=', 'commande_produits.commande_id')
                    ->whereBetween('commandes.date', [$date_debut, $date_fin]);

                $commandeProduit_menu = self::sansConsoInterne($commandeProduit_menu);


                $commandeProduit_menu = Outil::rajouteElements($commandeProduit_menu, $itemArray, 'commande_produits');

                $commandeProduit_menu = $commandeProduit_menu->
                    selectRaw('COALESCE(SUM(commande_produits.prix),0) as total, count(produits.id) as nombre, commande_produits.produit_id as menu_id')
                    ->whereNotNull('commande_produits.commande_produit_id')
                    ->groupBy(['produits.id','commande_produits.produit_id'])
                    ->get();

                $retour = array();
                foreach ($query as $value)
                {
                    $produit = Produit::find($value->produit_id);
                    if(isset($produit))
                    {
                        $famille = FamilleProduit::find($produit->famille_produit_id);
                        $parametres = array(
                            'total'                         => $produit->total,
                            'prix_de_revient_unitaire'      => $produit->prix_de_revient_unitaire,
                            'prix_achat_ttc'                => $produit->prix_achat_ttc,
                            'prix_achat_unitaire'           => $produit->prix_achat_unitaire,
                        );
                        $revient = Outil::donnePrixRevient($parametres);

                        $one = array(
                            'produit'       => $produit,
                            'famille'       => $famille,
                            'vendu'         => $value->nombre,
                            'montant'       => $value->total,
                            'revient'       => $revient,
                        );
                        array_push($retour, $one);
                    }
                }
                //Charger les menus
                if(isset($commandeProduit_menu) && count($commandeProduit_menu) > 0){
                    foreach ($commandeProduit_menu as $value)
                    {
                        $produit = Produit::find($value->menu_id);
                        if(isset($produit))
                        {
                            $famille = isset($produit->famille_produit_id) ? FamilleProduit::find($produit->famille_produit_id) : null;
                            $parametres = array(
                                'total'                         => $produit->total,
                                'prix_de_revient_unitaire'      => $produit->prix_de_revient_unitaire,
                                'prix_achat_ttc'                => $produit->prix_achat_ttc,
                                'prix_achat_unitaire'           => $produit->prix_achat_unitaire,
                            );
                            $revient = Outil::donnePrixRevient($parametres);

                            $one = array(
                                'produit'       => $produit,
                                'famille'       => $famille,
                                'vendu'         => $value->nombre,
                                'montant'       => $value->total,
                                'revient'       => $revient,
                            );
                            array_push($retour, $one);

                        }
                    }

                }
                //trier par famille
                //$retour = Outil::trieParFamille($retour);
                //$retour = collect($retour);
                //$retour = $retour->sortBy('montant', SORT_REGULAR, 'DESC');
            }
            if ($type == "produits_commandes_offerts")
            {
                $query = DB::table('commande_produits')
                ->join('commandes', 'commandes.id', '=', 'commande_produits.commande_id')
                ->where('commande_produits.offert', 1)
                ->whereBetween('commandes.date', [$date_debut, $date_fin]);
                if($entite_id){
                    $itemArray['entite_id']  = $entite_id;
                }
                $query = Outil::rajouteElements($query, $itemArray, 'commande_produits');
                $query = $query->selectRaw('COALESCE(SUM(commande_produits.prix),0) as total, count(commande_produits.produit_id) as nombre, commande_produits.produit_id')
                ->groupBy('commande_produits.produit_id');
                $query = $query->get();
                //dd($query);

                $retour = array();
                foreach ($query as $value)
                {
                    $produit = Produit::find($value->produit_id);
                    if(isset($produit))
                    {
                        $famille = FamilleProduit::find($produit->famille_produit_id);
                        $parametres = array(
                            'total'                         => $produit->total,
                            'prix_de_revient_unitaire'      => $produit->prix_de_revient_unitaire,
                            'prix_achat_ttc'                => $produit->prix_achat_ttc,
                            'prix_achat_unitaire'           => $produit->prix_achat_unitaire,
                        );
                        $revient = Outil::donnePrixRevient($parametres);

                        $one = array(
                            'produit'       => $produit,
                            'famille'       => $famille,
                            'vendu'         => $value->nombre,
                            'montant'       => $value->total,
                            'revient'       => $revient,
                        );
                        array_push($retour, $one);
                    }
                }


            }
            if ($type == "produits_commandes_pertes")
            {
                //dd("ici");
                $query = DB::table('commande_produits')
                ->join('commandes', 'commandes.id', '=', 'commande_produits.commande_id')
                ->where('commande_produits.perte', 1)
                ->whereBetween('commandes.date', [$date_debut, $date_fin]);
                if($entite_id){
                    $itemArray['entite_id']  = $entite_id;
                }

                $query = Outil::rajouteElements($query, $itemArray, 'commande_produits');
                $query = $query->selectRaw('COALESCE(SUM(commande_produits.prix),0) as total, count(commande_produits.produit_id) as nombre, commande_produits.produit_id')
                ->groupBy('commande_produits.produit_id');
                $query = $query->get();
                //dd($query->get());
                //dd($query);

                $retour = array();
                foreach ($query as $value)
                {
                    $produit = Produit::find($value->produit_id);
                    if(isset($produit))
                    {
                        $famille = FamilleProduit::find($produit->famille_produit_id);
                        $parametres = array(
                            'total'                         => $produit->total,
                            'prix_de_revient_unitaire'      => $produit->prix_de_revient_unitaire,
                            'prix_achat_ttc'                => $produit->prix_achat_ttc,
                            'prix_achat_unitaire'           => $produit->prix_achat_unitaire,
                        );
                        $revient = Outil::donnePrixRevient($parametres);

                        $one = array(
                            'produit'       => $produit,
                            'famille'       => $famille,
                            'vendu'         => $value->nombre,
                            'montant'       => $value->total,
                            'revient'       => $revient,
                        );
                        array_push($retour, $one);
                    }
                }
            }
            if ($type == "clients_commandes_offerts")
            {
                $query = DB::table('commande_produits')
                ->join('commandes', 'commandes.id', '=', 'commande_produits.commande_id')
                ->whereNotNull('commandes.client_id')
                ->where('commande_produits.offert', 1)
                ->whereBetween('commandes.date', [$date_debut, $date_fin]);
                if($entite_id){
                    $itemArray['entite_id']  = $entite_id;
                }
                $query = Outil::rajouteElements($query, $itemArray, 'commande_produits');
                $query = $query->selectRaw('COALESCE(SUM(commande_produits.prix),0) as total, count(commande_produits.produit_id) as nombre, client_id')
                ->groupBy('commandes.client_id');
                $query = $query->get();

                $retour = array();
                foreach ($query as $value)
                {
                    $client = Client::find($value->client_id);
                    if(isset($client))
                    {
                        $one = array(
                            'client'        => $client,
                            'revient'       => 0, //A coder car c'est le prix de tous les produits
                            'qte'           => $value->nombre,
                            'montant'       => $value->total,
                        );
                        array_push($retour, $one);
                    }
                }
            }
            if ($type == "ca_commandes_non_offerts")
            {
                //dd($date_debut, $date_fin);
                $query = DB::table('commande_produits')
                ->join('commandes', 'commandes.id', '=', 'commande_produits.commande_id')
                ->where('commande_produits.offert', 0)
                ->where('commande_produits.perte',0)
                ->whereNull('commande_produits.commande_produit_id')
                ->whereBetween('commandes.date', [$date_debut, $date_fin ])
                ->distinct('commande_produits.commande_id')
                ->groupby(['commande_produits.commande_id','commande_produits.id','commandes.id']);
                //$query = self::sansConsoInterne($query);

                if($entite_id)
                {
                    $itemArray['entite_id']  = $entite_id;
                }
                $query  = Outil::rajouteElements($query, $itemArray, 'commande_produits');

                $query  = $query->selectRaw('commande_produits.commande_id ,(COALESCE(SUM(commandes.total_to_pay ),0) ) as total')->get();
                $retour = 0 ;

                foreach($query as $onequery)
                {
                    $retour +=$onequery->total;
                    $historiquecloture = HistoriqueCloture::where('commande_id',$onequery->commande_id)->where('is_ci',1)->first();
                    if(isset($historiquecloture))
                    {
                        $retour -=$historiquecloture->montant;
                    }
                }
            }
            if ($type == "ca_commandes_offerts")
            {
                $query = DB::table('commande_produits')
                ->join('commandes', 'commandes.id', '=', 'commande_produits.commande_id')
                ->where('commande_produits.offert', 1)
                    ->whereNull('commande_produits.commande_produit_id')
                ->whereBetween('commandes.date', [$date_debut, $date_fin]);
                if($entite_id){
                    $itemArray['entite_id']  = $entite_id;
                }
                $query = Outil::rajouteElements($query, $itemArray, 'commande_produits');
                $query = $query->selectRaw('COALESCE(SUM(commande_produits.total),0) as total');
                $retour = $query->first()->total;
                //($date_debut, $date_fin, $type = null, $id_type = null, $itemArray =null, $offre = null)
                $commandeProduit_menu =  self::ca_commande_menu($date_debut, $date_fin, null, null, null, 1, null);

                if(isset($commandeProduit_menu)){

                    //$total_menu = $commandeProduit_menu->total;
                    $total_menu = $commandeProduit_menu;
                    if(isset($total_menu)){
                        $retour += $total_menu;
                    }
                }
            }
            if ($type == "ca_commandes_pertes")
            {
                $query = DB::table('commande_produits')
                    ->join('commandes', 'commandes.id', '=', 'commande_produits.commande_id')
                    ->where('commande_produits.perte', 1)
                    ->whereBetween('commandes.date', [$date_debut, $date_fin]);
                if($entite_id){
                    $itemArray['entite_id']  = $entite_id;
                }

                $query = Outil::rajouteElements($query, $itemArray, 'commande_produits');
                $query = $query->selectRaw('COALESCE(SUM(commande_produits.total),0) as total');
                $retour = $query->first()->total;
                //dd("ici",$retour );
                //($date_debut, $date_fin, $type = null, $id_type = null, $itemArray =null, $offre = null, $perte = null)
                // $commandeProduit_menu =  self::ca_commande_menu($date_debut, $date_fin,null,null,null,null,true);


                // if(isset($commandeProduit_menu)){

                //     $total_menu = $commandeProduit_menu;
                //     if(isset($total_menu)){
                //         $retour += $total_menu;
                //     }
                // }


                //dd($retour);
            }
            if ($type == "ca_commandes_liquide_pertes")
            {
                $query = DB::table('commande_produits')
                ->join('commandes', 'commandes.id', '=', 'commande_produits.commande_id')
                ->join('produits', 'produits.id', '=', 'commande_produits.produit_id')
                ->join('nomenclatures', 'nomenclatures.id', '=', 'produits.nomenclature_id')
                ->where('nomenclatures.nom', Outil::getOperateurLikeDB(), '%LIQUIDE%')
                ->where('commande_produits.perte', 1)
                ->whereBetween('commandes.date', [$date_debut, $date_fin]);
                if($entite_id){
                    $itemArray['entite_id']  = $entite_id;
                }
                $query = Outil::rajouteElements($query, $itemArray, 'commande_produits');
                $query = $query->selectRaw('COALESCE(SUM(commande_produits.total),0) as total');
                $retour = $query->first()->total;
                //dd($retour);
            }
            if ($type == "ca_commandes_liquide_non_offerts")
            {
                $query = DB::table('commande_produits')
                    ->join('commandes', 'commandes.id', '=', 'commande_produits.commande_id')
                    ->join('produits', 'produits.id', '=', 'commande_produits.produit_id')
                    ->join('nomenclatures', 'nomenclatures.id', '=', 'produits.nomenclature_id')
                    ->where('nomenclatures.nom', Outil::getOperateurLikeDB(), '%LIQUIDE%')
                    ->where('commande_produits.offert', 0)
                     ->where('commande_produits.perte',0)
                    ->whereBetween('commandes.date', [$date_debut, $date_fin]);
                $query = self::sansConsoInterne($query);
                if($entite_id){
                    $itemArray['entite_id']  = $entite_id;
                }
                $query = Outil::rajouteElements($query, $itemArray, 'commande_produits');
                $query = $query->selectRaw('COALESCE(SUM(commande_produits.total),0) as total');
                $retour = $query->first()->total;
                //dd($retour);
            }
            if ($type == "ca_commandes_liquide_offerts")
            {
                $query = DB::table('commande_produits')
                ->join('commandes', 'commandes.id', '=', 'commande_produits.commande_id')
                ->join('produits', 'produits.id', '=', 'commande_produits.produit_id')
                ->join('nomenclatures', 'nomenclatures.id', '=', 'produits.nomenclature_id')
                ->where('nomenclatures.nom', Outil::getOperateurLikeDB(), '%LIQUIDE%')
                ->where('commande_produits.offert', 1)
                ->whereBetween('commandes.date', [$date_debut, $date_fin]);
                if($entite_id){
                    $itemArray['entite_id']  = $entite_id;
                }
                $query = Outil::rajouteElements($query, $itemArray, 'commande_produits');
                $query = $query->selectRaw('COALESCE(SUM(commande_produits.total),0) as total');
                $retour = $query->first()->total;
                //dd($retour);
            }
            if ($type == "ca_commandes_solide_non_offerts")
            {
                $query = DB::table('commande_produits')
                ->join('commandes', 'commandes.id', '=', 'commande_produits.commande_id')
                ->join('produits', 'produits.id', '=', 'commande_produits.produit_id')
                ->join('nomenclatures', 'nomenclatures.id', '=', 'produits.nomenclature_id')
                ->where('nomenclatures.nom', Outil::getOperateurLikeDB(), '%SOLIDE%')
                ->where('commande_produits.offert', 0)
                                       ->where('commande_produits.perte',0)
                    ->whereBetween('commandes.date', [$date_debut, $date_fin]);
                $query = self::sansConsoInterne($query);
                if($entite_id){
                    $itemArray['entite_id']  = $entite_id;
                }
                $query = Outil::rajouteElements($query, $itemArray, 'commande_produits');
                $query = $query->selectRaw('COALESCE(SUM(commande_produits.total),0) as total');
                $retour = $query->first()->total;
                //dd($retour);
            }
            if ($type == "ca_commandes_solide_pertes")
            {
                $query = DB::table('commande_produits')
                    ->join('commandes', 'commandes.id', '=', 'commande_produits.commande_id')
                    ->join('produits', 'produits.id', '=', 'commande_produits.produit_id')
                    ->join('nomenclatures', 'nomenclatures.id', '=', 'produits.nomenclature_id')
                    ->where('nomenclatures.nom', Outil::getOperateurLikeDB(), '%SOLIDE%')
                    ->where('commande_produits.perte', 1)
                    ->whereBetween('commandes.date', [$date_debut, $date_fin]);
                if($entite_id){
                    $itemArray['entite_id']  = $entite_id;
                }
                $query = Outil::rajouteElements($query, $itemArray, 'commande_produits');
                $query = $query->selectRaw('COALESCE(SUM(commande_produits.total),0) as total');
                $retour = $query->first()->total;
                //dd($retour);
            }
            if ($type == "ca_commandes_solide_offerts")
            {
                $query = DB::table('commande_produits')
                ->join('commandes', 'commandes.id', '=', 'commande_produits.commande_id')
                ->join('produits', 'produits.id', '=', 'commande_produits.produit_id')
                ->join('nomenclatures', 'nomenclatures.id', '=', 'produits.nomenclature_id')
                ->where('nomenclatures.nom', Outil::getOperateurLikeDB(), '%SOLIDE%')
                ->where('commande_produits.offert', 1)
                ->whereBetween('commandes.date', [$date_debut, $date_fin]);
                if($entite_id){
                    $itemArray['entite_id']  = $entite_id;
                }
                $query = Outil::rajouteElements($query, $itemArray, 'commande_produits');
                $query = $query->selectRaw('COALESCE(SUM(commande_produits.total),0) as total');
                $retour = $query->first()->total;
                //dd($retour);
            }
            if ($type == "ca_commandes_a_livrer")
            {
                $type_commande_id = null;
                $typecommande = TypeCommande::where('nom','à livrer')->first();
                if(isset($typecommande))
                {
                    $type_commande_id = $typecommande->id;
                }

                $query = DB::table('commande_produits')
                ->join('commandes', 'commandes.id', '=', 'commande_produits.commande_id')
                ->where('commandes.type_commande_id', $type_commande_id)
                    ->whereNull('commande_produits.commande_produit_id')
                                       ->where('commande_produits.perte',0)
                    ->where('commande_produits.offert', 0)
                    ->whereBetween('commandes.date', [$date_debut, $date_fin]);
                $query = self::sansConsoInterne($query);
                if($entite_id){
                    $itemArray['entite_id']  = $entite_id;
                }
                $query = Outil::rajouteElements($query, $itemArray, 'commande_produits');
                $query = $query->selectRaw('COALESCE(SUM(commande_produits.total),0) as total');
                $retour = $query->first()->total;

                //($date_debut, $date_fin, $type = null, $id_type = null, $itemArray =null, $offre = null, $perte = null)

                $commandeProduit_menu =  self::ca_commande_menu($date_debut, $date_fin, 'alivrer', $type_commande_id);

                if(isset($commandeProduit_menu)){

                    //$total_menu = $commandeProduit_menu->total;
                    $total_menu = $commandeProduit_menu;
                    if(isset($total_menu)){
                        $retour += $total_menu;
                    }
                }
                //dd($retour);
            }
            if ($type == "ca_commandes_a_emporter")
            {
                $type_commande_id = null;
                $typecommande = Typecommande::where('nom','à emporter')->first();
                if(isset($typecommande))
                {
                    $type_commande_id = $typecommande->id;
                }

                $query = DB::table('commande_produits')
                ->join('commandes', 'commandes.id', '=', 'commande_produits.commande_id')
                ->where('commandes.type_commande_id', $type_commande_id)
                    ->whereNull('commande_produits.commande_produit_id')
                                       ->where('commande_produits.perte',0)
                    ->where('commande_produits.offert', 0)
                ->whereBetween('commandes.date', [$date_debut, $date_fin]);

                $query = self::sansConsoInterne($query);

                if($entite_id){
                    $itemArray['entite_id']  = $entite_id;
                }
                $query = Outil::rajouteElements($query, $itemArray, 'commande_produits');
                $query = $query->selectRaw('COALESCE(SUM(commande_produits.total),0) as total');
                $retour = $query->first()->total;

                $commandeProduit_menu =  self::ca_commande_menu($date_debut, $date_fin, 'emporter', $type_commande_id);

                if(isset($commandeProduit_menu)){

                    //$total_menu = $commandeProduit_menu->total;
                    $total_menu = $commandeProduit_menu;
                    if(isset($total_menu)){
                        $retour += $total_menu;
                    }
                }
                //dd($retour);
            }
            if ($type == "ca_commandes_sur_place")
            {
                //var_dump($date_debut . '====' . $date_fin);
                $type_commande_id = null;
                $typecommande = Typecommande::where('nom','sur place')->first();
                if(isset($typecommande))
                {
                    $type_commande_id = $typecommande->id;
                }

                $query = DB::table('commande_produits')
                ->join('commandes', 'commandes.id', '=', 'commande_produits.commande_id')
                ->where('commandes.type_commande_id', $type_commande_id)
                    ->whereNull('commande_produits.commande_produit_id')
                                       ->where('commande_produits.perte',0)
                    ->where('commande_produits.offert', 0)
                ->whereBetween('commandes.date', [$date_debut, $date_fin]);

                $query = self::sansConsoInterne($query);

                if($entite_id){
                    $itemArray['entite_id']  = $entite_id;
                }
                $query = Outil::rajouteElements($query, $itemArray, 'commande_produits');
                $query = $query->selectRaw('COALESCE(SUM(commande_produits.total),0) as total');
                $retour = $query->first()->total;

                $commandeProduit_menu =  self::ca_commande_menu($date_debut, $date_fin, 'surplace', $type_commande_id);

                if(isset($commandeProduit_menu)){

                    $total_menu = $commandeProduit_menu;
                    if(isset($total_menu)){
                        $retour += $total_menu;
                    }
                }

            }
            if ($type == "ca_commandes_conso_interne")
            {

                    $query = DB::table('historique_clotures')
                        ->join('commandes', 'commandes.id', '=', 'historique_clotures.commande_id')
                        ->where('historique_clotures.is_ci', '=', 1)
                        ->whereBetween('historique_clotures.date', [$date_debut, $date_fin]);
                    if($entite_id){
                        $itemArray['entite_id']  = $entite_id;
                    }
                    $query = Outil::rajouteElements($query, $itemArray, 'commande_produits');
                    $query = $query->selectRaw('COALESCE(SUM(historique_clotures.montant),0) as total');
                    $retour = $query->first()->total;
                    //dd("ici",$retour);

                    //  ca_commande_menu($date_debut, $date_fin, $type = null, $id_type = null, $itemArray =null, $offre = null, $perte = null, $conso_interne = null)
                    // $commandeProduit_menu =  self::ca_commande_menu($date_debut, $date_fin, null, null, $itemArray, false, null, 1);

                    // if(isset($commandeProduit_menu)){

                    //     //$total_menu = $commandeProduit_menu->total;
                    //     $total_menu = $commandeProduit_menu;
                    //     if(isset($total_menu)){
                    //         $retour += $total_menu;
                    //     }
                    // }

                //}



                //dd($retour);
            }
            if ($type == "produits_commandes_conso_interne")
            {
                //dd("ici");
                //Selectionner tous les produits des commandes

                $query = DB::table('commande_produits')
                    ->join('commandes', 'commandes.id', '=', 'commande_produits.commande_id')
                    ->whereNull('commande_produits.commande_produit_id')
                    ->whereBetween('commandes.date', [$date_debut, $date_fin]);

                $query = self::sansConsoInterne($query, false);

                if($entite_id){
                    $itemArray['entite_id']  = $entite_id;
                }

                $query = Outil::rajouteElements($query, $itemArray, 'commande_produits');
                $query = $query->selectRaw('COALESCE(SUM(commande_produits.prix),0) as total, count(commande_produits.produit_id) as nombre, produit_id')
                    ->groupBy('commande_produits.produit_id');
                $query = $query->get();

                //Selectionner tous les menus des commandes

                $commandeProduit_menu  = CommandeProduit::query()
                    ->whereNotNull('commande_produits.commande_produit_id')
                    ->join('produits', 'produits.id', '=', 'commande_produits.produit_id')
                    ->join('commandes', 'commandes.id', '=', 'commande_produits.commande_id')
                    ->whereBetween('commandes.date', [$date_debut, $date_fin]);

                $commandeProduit_menu = self::sansConsoInterne($commandeProduit_menu, false);


                $commandeProduit_menu = Outil::rajouteElements($commandeProduit_menu, $itemArray, 'commande_produits');

                $commandeProduit_menu = $commandeProduit_menu->
                    selectRaw('COALESCE(SUM(commande_produits.prix),0) as total, count(produits.id) as nombre, commande_produits.produit_id as menu_id')
                    ->whereNotNull('commande_produits.commande_produit_id')
                    ->groupBy(['produits.id','commande_produits.produit_id'])
                    ->get();

                $retour = array();
                foreach ($query as $value)
                {
                    $produit = Produit::find($value->produit_id);
                    if(isset($produit))
                    {
                        $famille = FamilleProduit::find($produit->famille_produit_id);
                        $parametres = array(
                            'total'                         => $produit->total,
                            'prix_de_revient_unitaire'      => $produit->prix_de_revient_unitaire,
                            'prix_achat_ttc'                => $produit->prix_achat_ttc,
                            'prix_achat_unitaire'           => $produit->prix_achat_unitaire,
                        );
                        $revient = Outil::donnePrixRevient($parametres);

                        $one = array(
                            'produit'       => $produit,
                            'famille'       => $famille,
                            'vendu'         => $value->nombre,
                            'montant'       => $value->total,
                            'revient'       => $revient,
                        );
                        array_push($retour, $one);
                    }
                }
                //Charger les menus
                if(isset($commandeProduit_menu) && count($commandeProduit_menu) > 0){
                    foreach ($commandeProduit_menu as $value)
                    {
                        $produit = Produit::find($value->menu_id);
                        if(isset($produit))
                        {
                            $famille = isset($produit->famille_produit_id) ? FamilleProduit::find($produit->famille_produit_id) : null;
                            $parametres = array(
                                'total'                         => $produit->total,
                                'prix_de_revient_unitaire'      => $produit->prix_de_revient_unitaire,
                                'prix_achat_ttc'                => $produit->prix_achat_ttc,
                                'prix_achat_unitaire'           => $produit->prix_achat_unitaire,
                            );
                            $revient = Outil::donnePrixRevient($parametres);

                            $one = array(
                                'produit'       => $produit,
                                'famille'       => $famille,
                                'vendu'         => $value->nombre,
                                'montant'       => $value->total,
                                'revient'       => $revient,
                            );
                            array_push($retour, $one);
                        }
                    }

                    //   dd($retour);
                }
            }
            if ($type == "nombre_livraison")
            {
                //dd('ici');
                $type_commande_id = null;
                $typecommande = Typecommande::where('type',1)->first();
                if(isset($typecommande))
                {
                    $type_commande_id = $typecommande->id;
                }

                $query = DB::table('commandes')
                ->where('type_commande_id', $type_commande_id)
                ->whereBetween('date', [$date_debut, $date_fin]);
                //$query = self::sansConsoInterne($query);
                if($entite_id){
                    $itemArray['entite_id']  = $entite_id;
                }
                //dd($query->get());
                $query = Outil::rajouteElements($query, $itemArray);
                $retour = $query->count();
                //dd($retour);
            }
            if ($type == "nombre_emporter")
            {
                $type_commande_id = null;
                $typecommande = Typecommande::where('type',2)->first();
                if(isset($typecommande))
                {
                    $type_commande_id = $typecommande->id;
                }

                $query = DB::table('commandes')
                ->where('commandes.type_commande_id', $type_commande_id)
                ->whereBetween('commandes.date', [$date_debut, $date_fin]);
                //$query = self::sansConsoInterne($query);
                if($entite_id){
                    $itemArray['entite_id']  = $entite_id;
                }
                $query = Outil::rajouteElements($query, $itemArray);
                $retour = $query->count();
                //dd($retour);
            }
            if ($type == "nombre_de_couverts")
            {
                $type_commande_id = null;
                $typecommande = Typecommande::where('type',3)->first();
                if(isset($typecommande))
                {
                    $type_commande_id = $typecommande->id;
                }

                $query = DB::table('commandes')
                ->where('commandes.type_commande_id', $type_commande_id)
                ->whereBetween('commandes.date', [$date_debut, $date_fin]);
                //$query = self::sansConsoInterne($query);
                if($entite_id){
                    $itemArray['entite_id']  = $entite_id;
                }
                $query = Outil::rajouteElements($query, $itemArray);
                $retour = $query->count();
                // $query = DB::table('commandes')
                //     ->whereBetween('commandes.date', [$date_debut, $date_fin]);
                // $query = self::sansConsoInterne($query);
                // if($entite_id){
                //     $itemArray['entite_id']  = $entite_id;
                // }

                // $query = Outil::rajouteElements($query, $itemArray);
                // $query = $query->selectRaw('COALESCE(SUM(commandes.nbre_personne),0) as total');
                // $retour = $query->first()->total;
            }

            if ($type == "recap_cloture_caisse")
            {

                $ca_sur_place = Outil::donneElementsEtat("ca_commandes_sur_place", $itemArray, $query);
                $nombre_de_couverts = Outil::donneElementsEtat("nombre_de_couverts", $itemArray, $query);

                $ca_a_livrer = Outil::donneElementsEtat("ca_commandes_a_livrer", $itemArray, $query);
                $nombre_livraison = Outil::donneElementsEtat("nombre_livraison", $itemArray, $query);

                $ca_a_emporter = Outil::donneElementsEtat("ca_commandes_a_emporter", $itemArray, $query);
                $nombre_emporter = Outil::donneElementsEtat("nombre_emporter", $itemArray, $query);

                $couvert_moyen = 0;
                $panier_moyen_livraison = 0;
                $panier_moyen_emporter = 0;
                if($nombre_de_couverts > 0)
                {
                    $couvert_moyen = round($ca_sur_place / $nombre_de_couverts,2);
                }
                if($nombre_livraison > 0)
                {
                    $panier_moyen_livraison = round($ca_a_livrer / $nombre_livraison,2);
                }
                if($ca_a_emporter > 0)
                {
                    $panier_moyen_emporter = round($ca_sur_place / $nombre_emporter,2);
                }

                $retourArrayOne = array(
                    "ca_non_offerts"            => Outil::donneElementsEtat("ca_commandes_non_offerts", $itemArray, $query),
                    "ca_offerts"                => Outil::donneElementsEtat("ca_commandes_offerts", $itemArray, $query),
                    "ca_liquide_pertes"         => Outil::donneElementsEtat("ca_commandes_liquide_pertes", $itemArray, $query),
                    "ca_liquide_non_offerts"    => Outil::donneElementsEtat("ca_commandes_liquide_non_offerts", $itemArray, $query),
                    "ca_liquide_offerts"        => Outil::donneElementsEtat("ca_commandes_liquide_offerts", $itemArray, $query),
                    "ca_solide_non_offerts"     => Outil::donneElementsEtat("ca_commandes_solide_non_offerts", $itemArray, $query),
                    "ca_solide_pertes"          => Outil::donneElementsEtat("ca_commandes_solide_pertes", $itemArray, $query),
                    "ca_solide_offerts"         => Outil::donneElementsEtat("ca_commandes_solide_offerts", $itemArray, $query),
                    "ca_a_livrer"               => $ca_a_livrer,
                    "ca_a_emporter"             => $ca_a_emporter,
                    "ca_sur_place"              => $ca_sur_place,
                    "nombre_de_couverts"        => $nombre_de_couverts,
                    "nombre_livraison"          => $nombre_livraison,
                    "nombre_emporter"           => $nombre_emporter,
                    "couvert_moyen"             => $couvert_moyen,
                    "panier_moyen_livraison"    => $panier_moyen_livraison,
                    "panier_moyen_emporter"     => $panier_moyen_emporter,
                );
                $retour = $retourArrayOne;
            }
            if ($type == "elements_caisse")
            {
                //Total appros receveur
                $queryApprosReceveurs = DB::table("appro_cashs");
                $queryApprosReceveurs = $queryApprosReceveurs->whereBetween('date', [$date_debut, $date_fin]);
                $queryApprosReceveurs = $queryApprosReceveurs->where('caisse_destinataire_id', $caisse_id);
                $queryApprosReceveurs = $queryApprosReceveurs->orderBy('date', 'ASC')->get();

                //Total appros destinatair
                $queryApprosEmmetteurs = DB::table("appro_cashs");
                $queryApprosEmmetteurs = $queryApprosEmmetteurs->whereBetween('date', [$date_debut, $date_fin]);
                $queryApprosEmmetteurs = $queryApprosEmmetteurs->where('caisse_source_id', $caisse_id);
                $queryApprosEmmetteurs = $queryApprosEmmetteurs->orderBy('date', 'ASC')->get();

                //Total sortie
                $querySorties          = DB::table("sortie_cashs");
                $querySorties          = $querySorties->whereBetween('date', [$date_debut, $date_fin]);
                $querySorties          = $querySorties->where('caisse_id', $caisse_id);
                $querySorties          = $querySorties->orderBy('date', 'ASC')->get();

                $caisse                = Caisse::find($caisse_id);
                $fournisseur           = null;
                $solde_caisse          = null;

                //Solde veille

                if(isset($caisse_id)){

                    $parametres = array(
                        'date_debut'                    => isset($args['date_start']) ? $args["date_start"] : null,
                        'date_fin'                      => isset($args['date_end']) ? $args["date_end"] : null,
                        'caisse_id'                     =>  isset($args['caisse_id']) ?$args["caisse_id"] : null,
                        'cloture_caisse_id'             => isset($args['cloture_caisse_id']) ? $args['cloture_caisse_id'] : null,
                        'fournisseur_id'                => isset($args['fournisseur_id']) ? $args['fournisseur_id'] : null,
                    );

                    $solde_caisse                       = $parametres;
                    if(isset($solde_caisse) && count($solde_caisse) > 0){
                        // $solde_caisse = $solde_caisse[0]["depense_caisse"];
                    }
                }

                //Total reglements dépenses
                $filtres = 'date_start:"'.$date_debut.'",date_end:"'.$date_fin.'",caisse_id:'.$caisse_id . ',ordre:2';
                if(isset($fournisseur_id)){
                    $filtres      = $filtres . ',fournisseur_id:'.$fournisseur_id . ',paiement_cash:1';

                    $fournisseur  = Tier::find($fournisseur_id);
                }
                if(isset($entites)){
                    $filtres      = $filtres . ',entites:"'.$entites . '"';
                }
                $filtres      = $filtres .',paiement_cash:1';
                $queryRegelments  = Outil::getAllItemsWithGraphQl("reglements", $filtres);

                //Toutes les entités
                $queryEntites     = DB::table("entites");
                $queryEntites     = $queryEntites->get();

                $totalGeneralAppros          = 0; //Total de tous les appros
                $totalGeneralDepenses        = 0; //Total de tous les reglements dépenses
                $totalGeneralApprosEmetteurs = 0; //Total de tous les appros emetteurs
                $totalGeneralSortie          = 0; //Total de toutes les sorties

                foreach ($queryApprosReceveurs as $valueappro)
                {
                    $totalGeneralAppros += $valueappro->montant;
                }

                foreach ($queryApprosEmmetteurs as $valueappro)
                {
                    $totalGeneralApprosEmetteurs += $valueappro->montant;
                }

                foreach ($querySorties as $valuesortie)
                {
                    $totalGeneralSortie += $valuesortie->montant;
                }

                //Total par entité
                $totaux_entites  = array();

                foreach ($queryEntites as $value)
                {
                    $totalGlobal = 0;
                    $totalCompta = 0;
                    $totalHorsCompta = 0;
                    foreach ($queryRegelments as $value2)
                    {
                        if($value->id == $value2["depense"]["point_vente_id"])
                        {
                            $totalGlobal += $value2["montant"];
                            if($value2["depense"]["compta"] == 0)
                            {
                                $totalCompta += $value2["montant"];
                            }
                            else if($value2["depense"]["compta"] > 0)
                            {
                                $totalHorsCompta += $value2["montant"];
                            }
                        }
                    }
                    array_push($totaux_entites,  array(
                        "entite_id"             => $value->id,
                        "entite"                => $value->nom,
                        "total_global"          => $totalGlobal,
                        "total_compta"          => $totalCompta,
                        "total_hors_compta"     => $totalHorsCompta,
                    ));

                    $totalGeneralDepenses += $totalGlobal;
                }

                $retour = array(
                    'approcahs'             => $queryApprosReceveurs,
                    'approcahs_emetteur'    => $queryApprosEmmetteurs,
                    'sortie'                => $querySorties,
                    'reglements'            => $queryRegelments,
                    'entites'               => $queryEntites,
                    'totaux_entites'        => $totaux_entites,
                    'total_depense'         => $totalGeneralDepenses,
                    'total_appro'           => $totalGeneralAppros,
                    'total_appro_emetteur'  => $totalGeneralApprosEmetteurs,
                    'total_sortie'          => $totalGeneralSortie,
                    'caisse'                => $caisse,
                    "date_debut"            => self::resolveAllDateCompletFR($date_debut, false),
                    "date_fin"              => self::resolveAllDateCompletFR($date_fin, false),
                    "fournisseur"           => $fournisseur,
                    "solde_caisse"          => $solde_caisse
                );
                // dd($retour);
            }
            if ($type == "elements_resume")
            {
                $date_debut = $itemArray["date_debut"];
                $date_fin = $itemArray["date_fin"];

                $diffJours = Outil::nombreJoursEntreDeuxDates($date_debut, $date_fin);

                $donneesJour = array();
                $donneesCouvert = array();
                $donneesCaNonOffert = array();
                $donneesCaOffert = array();
                $donneesCaTotal = array();
                $donneesLivraison = array();
                $donneesEmporte = array();
                $donneesEncCash = array();
                $donneesEncBanque = array();
                $donneesEncaissement = array();
                $donneesManquant = array();
                $donneesBilletage = array();
                for($i = 0; $i <= $diffJours; $i++)
                {
                    $dateRequete = Outil::donneDateParRapportNombreJour($date_debut, $i);
                    $dateRequeteDebut = $dateRequete." 00:00";
                    $dateRequeteFin = $dateRequete." 23:59";

                    $datedateRequeteFr = Outil::dateEnFrancais($dateRequete);
                    $totalCa = 0;

                    //Jours
                    array_push($donneesJour,  array(
                        "date"                  => $dateRequete,
                        "date_fr"               => $datedateRequeteFr,
                    ));

                    //Nombre de couverts
                    $query = DB::table('commandes')
                    ->whereBetween('commandes.date', [$dateRequeteDebut, $dateRequeteFin]);
                    $query = Outil::rajouteElements($query, $itemArray);
                    $query = $query->selectRaw('COALESCE(SUM(commandes.type_commande_id),0) as total');
                    $query = $query->first()->total;
                    array_push($donneesCouvert,  array(
                        "date"                  => $dateRequete,
                        "date_fr"               => $datedateRequeteFr,
                        "total"                 => $query,
                    ));

                    //CA non offerts
                    $query = DB::table('commande_produits')
                    ->join('commandes', 'commandes.id', '=', 'commande_produits.commande_id')
                    ->where('commande_produits.offert', 0)
                    ->whereBetween('commandes.date', [$dateRequeteDebut, $dateRequeteFin]);
                    $query = Outil::rajouteElements($query, $itemArray, 'commande_produits');
                    $query = $query->selectRaw('COALESCE(SUM(commande_produits.prix),0) as total');
                    $query = $query->first()->total;
                    $totalCa += $query;
                    array_push($donneesCaNonOffert,  array(
                        "date"                  => $dateRequete,
                        "date_fr"               => $datedateRequeteFr,
                        "total"                 => $query,
                    ));

                    //CA offerts
                    $query = DB::table('commande_produits')
                    ->join('commandes', 'commandes.id', '=', 'commande_produits.commande_id')
                    ->where('commande_produits.offert', 1)
                    ->whereBetween('commandes.date', [$dateRequeteDebut, $dateRequeteFin]);
                    $query = Outil::rajouteElements($query, $itemArray, 'commande_produits');
                    $query = $query->selectRaw('COALESCE(SUM(commande_produits.prix),0) as total');
                    $query = $query->first()->total;
                    $totalCa += $query;
                    array_push($donneesCaOffert,  array(
                        "date"                  => $dateRequete,
                        "date_fr"               => $datedateRequeteFr,
                        "total"                 => $query,
                    ));

                    //CA total
                    array_push($donneesCaTotal,  array(
                        "date"                  => $dateRequete,
                        "date_fr"               => $datedateRequeteFr,
                        "total"                 => $totalCa,
                    ));

                    //Nbre commande à livrer
                    $typecommande = Typecommande::where('type',3)->first();
                    if(isset($typecommande))
                    {
                        $query = DB::table('commandes')
                        ->where('commandes.type_commande_id', $typecommande->id)
                        ->whereBetween('commandes.date', [$dateRequeteDebut, $dateRequeteFin]);
                        $query = Outil::rajouteElements($query, $itemArray);
                        $query = $query->count();
                        array_push($donneesLivraison,  array(
                            "date"                  => $dateRequete,
                            "date_fr"               => $datedateRequeteFr,
                            "total"                 => $query,
                        ));
                    }

                    //Nbre commande à emporter
                    $typecommande = TypeCommande::where('type',2)->first();
                    if(isset($typecommande))
                    {
                        $query = DB::table('commandes')
                        ->where('commandes.type_commande_id', $typecommande->id)
                        ->whereBetween('commandes.date', [$dateRequeteDebut, $dateRequeteFin]);
                        $query = Outil::rajouteElements($query, $itemArray);
                        $query = $query->count();
                        array_push($donneesEmporte,  array(
                            "date"                  => $dateRequete,
                            "date_fr"               => $datedateRequeteFr,
                            "total"                 => $query,
                        ));
                    }

                    //Total encaissement cash
                    $modepaiements = ModePaiement::where('paiement_cash',1)->get();
                    //dd($modepaiements);
                    $modePaiementsArray = array();
                    $totalEncCash = 0;
                    foreach ($modepaiements as $value)
                    {
                        $query = DB::table('cloture_caisse_mode_paiements')
                        ->join('cloture_caisses', 'cloture_caisses.id', '=', 'cloture_caisse_mode_paiements.cloture_caisse_id')
                        //->where('cloture_caisses.type', 0)
                        ->where('cloture_caisse_mode_paiements.mode_paiement_id', $value->id)
                        ->whereBetween('cloture_caisses.created_at', [$dateRequeteDebut, $dateRequeteFin]);
                        $query = Outil::rajouteElements($query, $itemArray, 'encaissements');
                        $query = $query->selectRaw('COALESCE(SUM(cloture_caisse_mode_paiements.montant),0) as total');
                        $query = $query->first()->total;
                        $totalEncCash += $query;
                    }
                    array_push($donneesEncCash,  array(
                        "date"                  => $dateRequete,
                        "date_fr"               => $datedateRequeteFr,
                        "total"                 => $totalEncCash,
                    ));

                    //Total encaissement banque
                    $modepaiements = ModePaiement::where('is_banque',1)->get();
                    $modePaiementsArray = array();
                    $totalEncBanque = 0;
                    foreach ($modepaiements as $value)
                    {
                        $query = DB::table('cloture_caisse_mode_paiements')
                        ->join('cloture_caisses', 'cloture_caisses.id', '=', 'cloture_caisse_mode_paiements.cloture_caisse_id')
                        //->where('cloture_caisses.type', 0)
                        ->where('cloture_caisse_mode_paiements.mode_paiement_id', $value->id)
                        ->whereBetween('cloture_caisses.created_at', [$dateRequeteDebut, $dateRequeteFin]);
                        $query = Outil::rajouteElements($query, $itemArray, 'encaissements');
                        $query = $query->selectRaw('COALESCE(SUM(cloture_caisse_mode_paiements.montant),0) as total');
                        $query = $query->first()->total;
                        $totalEncBanque += $query;
                    }
                    array_push($donneesEncBanque,  array(
                        "date"                  => $dateRequete,
                        "date_fr"               => $datedateRequeteFr,
                        "total"                 => $totalEncBanque,
                    ));

                    //Encaissements clotures caisse
                    $modepaiements = ModePaiement::all();
                    $modePaiementsArray = array();
                    foreach ($modepaiements as $value)
                    {
                        $query = DB::table('cloture_caisse_mode_paiements')
                        ->join('cloture_caisses', 'cloture_caisses.id', '=', 'cloture_caisse_mode_paiements.cloture_caisse_id')
                        //->where('cloture_caisses.type', 0)
                        ->where('cloture_caisse_mode_paiements.mode_paiement_id', $value->id)
                        ->whereBetween('cloture_caisses.created_at', [$dateRequeteDebut, $dateRequeteFin]);
                        $query = Outil::rajouteElements($query, $itemArray, 'encaissements');
                        $query = $query->selectRaw('COALESCE(SUM(cloture_caisse_mode_paiements.montant),0) as total');
                        $query = $query->first()->total;
                        array_push($modePaiementsArray,  array(
                            "date"                  => $dateRequete,
                            "date_fr"               => $datedateRequeteFr,
                            "modepaiement"          => $value->nom,
                            "total"                 => $query,
                        ));
                    }
                    array_push($donneesEncaissement,  array(
                        "date"                  => $dateRequete,
                        "date_fr"               => $datedateRequeteFr,
                        "modepaiements"         => $modePaiementsArray,
                    ));

                    //Manquant
                    $query = DB::table('cloture_caisses')
                    //->where('cloture_caisses.type', 0)
                    ->whereBetween('cloture_caisses.created_at', [$dateRequeteDebut, $dateRequeteFin]);
                    $query = Outil::rajouteElements($query, $itemArray, 'encaissements');
                    $query = $query->selectRaw('COALESCE(SUM(cloture_caisses.montant_manquant),0) as total');
                    $query = $query->first()->total;
                    array_push($donneesManquant,  array(
                        "date"                  => $dateRequete,
                        "date_fr"               => $datedateRequeteFr,
                        "total"                 => $query,
                    ));

                    //Billetages
                    /*  $filtres = 'date_start:"'.$dateRequeteDebut.'",date_end:"'.$dateRequeteFin.'"';
                    $billetages = Outil::getOneItemWithFilterGraphQl("billetages", $filtres);
                    array_push($donneesBilletage,  array(
                        "date"                  => $dateRequete,
                        "date_fr"               => $datedateRequeteFr,
                        "billetages"            => $billetages,
                    )); */


                }

                //Billetages
                $dateGlobalDebut = $date_debut." 00:00";
                $dateGlobalFin = $date_fin." 23:59";
                $typebillets = Typebillet::all();
                $totalBilletage = 0;

                foreach ($typebillets as $value)
                {
                    $query = DB::table('cloture_caisse_type_billets')
                    ->join('cloture_caisses', 'cloture_caisses.id', '=', 'cloture_caisse_type_billets.cloture_caisse_id')
                   // ->where('cloture_caisses.type', 0)
                    ->where('cloture_caisse_type_billets.type_billet_id', $value->id)
                    ->whereBetween('cloture_caisses.created_at', [$dateGlobalDebut, $dateGlobalFin]);

                    $query = Outil::rajouteElements($query, $itemArray, 'encaissements');

                    $query = $query->selectRaw('COALESCE(SUM(cloture_caisse_type_billets.nombre),0) as nombre');

                    $query = $query->first()->nombre;
                    $total = $query * $value->valeur;
                   // dd()
                    $totalBilletage += $total;
                    array_push($donneesBilletage,  array(
                        "typebillet"            => $value->nom,
                        "nombre"                => $query,
                        "total"                 => $total,
                    ));

                }
                //dd($totalBilletage);


                $retour = array(
                    'jours'                     => $donneesJour,
                    'nbre_couvert'              => $donneesCouvert,
                    'ca_total_non_offert'       => $donneesCaNonOffert,
                    'ca_total_offert'           => $donneesCaOffert,
                    'ca_total'                  => $donneesCaTotal,
                    'nbre_livraison'            => $donneesLivraison,
                    'nbre_a_emporter'           => $donneesEmporte,
                    'total_cash'                => $donneesEncCash,
                    'total_banque'              => $donneesEncBanque,
                    'encaissements'             => $donneesEncaissement,
                    'manquant'                  => $donneesManquant,
                    'billetages'                => $donneesBilletage,
                    'total_billetage'           => $totalBilletage,
                );
            }
            if ($type == "ca_commandes_menu_non_offerts")
            {
                $retour = 0;

                $commandeProduit_menu =  self::ca_commande_menu($date_debut, $date_fin, null, null, $itemArray, false, null);
                //$query = self::sansConsoInterne($query);
                // $commandeProduit_menu =  self::ca_commande_menu($date_debut, $date_fin,null,null,$itemArray);

                if(isset($commandeProduit_menu)){

                    $total_menu = $commandeProduit_menu;
                    if(isset($total_menu)){
                        $retour += $total_menu;
                    }
                }
            }
        }
        return $retour;
    }

    public static function sansConsoInterne($query, $avecousans = true)
    {
        //Noueaux scenario sur les consos internes, ce process suivant , est le bon et c'est a decommente

        if($avecousans){
            $query = $query->where('commandes.c_interne', '!=', 1);
        }else{
           // dd("ici");
            $query = $query->where('commandes.c_interne', '=', 1);
        }

        return $query;
    }


    //Donne le solde calculé
    public static function donneSoldeCalculei($item_id, $soldeComptable = false, $from = "societefacturation", $date_debut = null, $date_fin = null)
    {
        //Solde  = appros[receveur] - (appros[emetteur] + sorties cash + versements banques)
        $retour = 0;



        if (isset($item_id))
        {
            if ($soldeComptable == true)
            {
                if($from == "societefacturation")
                {
                    $caissesToSearch = Caisse::whereNotNull('entite_id')->whereIn('entite_id', Entite::where('societe_facturation_id', $item_id)->get(['id']))->get(['id']);
                }
                else if($from == "caisse")
                {
                    $caissesToSearch = Caisse::whereNotNull('entite_id')->where('entite_id', $item_id)->get(['id']);
                }
            }

            //****Total entrée****
            //Total appros receveur
            $queryApprosReceveurs = DB::table("appro_cashs")->select(DB::raw("COALESCE(SUM(montant),0) as total"));
            if(isset($date_debut) && isset($date_fin)){
                $queryApprosReceveurs = $queryApprosReceveurs->whereBetween('date', [$date_debut, $date_fin]);
            }

            if ($soldeComptable == true)
            {
                $queryApprosReceveurs = $queryApprosReceveurs->whereIn('caisse_destinataire_id', $caissesToSearch);
                $queryApprosReceveurs = $queryApprosReceveurs->whereNull('caisse_source_id');
            }
            else
            {
                $queryApprosReceveurs = $queryApprosReceveurs->where('caisse_destinataire_id', $item_id);
            }
            $queryApprosReceveurs = $queryApprosReceveurs->first();

            //Total paiements commande
            $queryPaiementsComms = DB::table("paiements")->select(DB::raw("COALESCE(SUM(montant),0) as total"))->whereNotNull('commande_id');
            if(isset($date_debut) && isset($date_fin)){
                $queryPaiementsComms = $queryPaiementsComms->whereBetween('date', [$date_debut, $date_fin]);
            }
            if ($soldeComptable == true)
            {
                $queryPaiementsComms = $queryPaiementsComms->whereIn('caisse_id', $caissesToSearch);
            }
            else
            {
                $queryPaiementsComms = $queryPaiementsComms->where('caisse_id', $item_id);
            }
            $queryPaiementsComms = $queryPaiementsComms->whereIn('mode_paiement_id', ModePaiement::where('paiement_cash', 1)->get(['id']));

            if ($soldeComptable == true)
            {
                $queryPaiementsComms = $queryPaiementsComms->whereIn('commande_id', Commande::where('compta', 0)->get(['id']));
            }
            $queryPaiementsComms     = $queryPaiementsComms->first();

            //Total paiements facture
            // $queryPaiementsFacs = DB::table("paiements")->select(DB::raw("COALESCE(SUM(montant),0) as total"))->whereNotNull('facture_id');
            // if(isset($date_debut) && isset($date_fin)){
            //     $queryPaiementsFacs = $queryPaiementsFacs->whereBetween('created_at', [$date_debut, $date_fin]);
            // }
            // if ($soldeComptable == true)
            // {
            //     $queryPaiementsFacs = $queryPaiementsFacs->whereIn('caisse_id', $caissesToSearch);
            // }
            // else
            // {
            //     $queryPaiementsFacs = $queryPaiementsFacs->where('caisse_id', $item_id);
            // }
            // $queryPaiementsFacs = $queryPaiementsFacs->whereIn('mode_paiement_id', Modepaiement::where('paiement_cash', 1)->get(['id']));

            // if ($soldeComptable == true)
            // {
            //     $queryPaiementsFacs = $queryPaiementsFacs->whereIn('facture_id', Facture::where('compta', 0)->get(['id']));
            // }
            // $queryPaiementsFacs = $queryPaiementsFacs->first();


            //****Total sortie****
            //Total appros emetteur
            $queryApprosEmetteurs = DB::table("appro_cashs")->select(DB::raw("COALESCE(SUM(montant),0) as total"));
            if(isset($date_debut) && isset($date_fin)){
                $queryApprosEmetteurs = $queryApprosEmetteurs->whereBetween('date', [$date_debut, $date_fin]);
            }
            if ($soldeComptable == true)
            {
                $queryApprosEmetteurs = $queryApprosEmetteurs->whereIn('caisse_source_id', $caissesToSearch);
                $queryApprosEmetteurs = $queryApprosEmetteurs->whereNull('caisse_source_id');
            }
            else
            {
                $queryApprosEmetteurs = $queryApprosEmetteurs->where('caisse_source_id', $item_id);
            }
            $queryApprosEmetteurs = $queryApprosEmetteurs->first();

            //Total sorties cash
            $querySortieCashs = DB::table("sortie_cashs")->select(DB::raw("COALESCE(SUM(montant),0) as total"));
            if(isset($date_debut) && isset($date_fin)){
                $querySortieCashs = $querySortieCashs->whereBetween('date', [$date_debut, $date_fin]);
            }
            if ($soldeComptable == true)
            {
                $querySortieCashs = $querySortieCashs->whereIn('caisse_id', $caissesToSearch);
            }
            else
            {
                $querySortieCashs = $querySortieCashs->where('caisse_id', $item_id);
            }
            $querySortieCashs = $querySortieCashs->first();

            $queryLigneCredit = DB::table("credit_clients")->select(DB::raw("COALESCE(SUM(montant),0) as total"))->where('caisse_id', $item_id);
            $queryLigneCredit->whereIn('mode_paiement_id', Modepaiement::where('paiement_cash', 1)->get(['id']));
            if(isset($date_debut) && isset($date_fin)){
                $queryLigneCredit = $queryLigneCredit->whereBetween('date', [$date_debut, $date_fin]);
            }

            $queryLigneCredit = $queryLigneCredit->first();
            //Total versements
            // $queryVersements = DB::table("versements")->select(DB::raw("COALESCE(SUM(montant),0) as total"));
            // if(isset($date_debut) && isset($date_fin)){
            //     $queryVersements = $queryVersements->whereBetween('date', [$date_debut, $date_fin]);
            // }
            // if ($soldeComptable == true)
            // {
            //     $queryVersements = $queryVersements->whereIn('caisse_id', $caissesToSearch);
            // }
            // else
            // {
            //     $queryVersements = $queryVersements->where('caisse_id', $item_id);
            // }
            // $queryVersements = $queryVersements->first();

            //Total dépenses
            $queryDepenses = DB::table("paiements")->select(DB::raw("COALESCE(SUM(montant),0) as total"))->whereNotNull('depense_id');
            if(isset($date_debut) && isset($date_fin)){
                $queryDepenses = $queryDepenses->whereBetween('date', [$date_debut, $date_fin]);
            }
            if ($soldeComptable == true)
            {
                $entitesToSearch = Pointvente::where('societe_facturation_id', $item_id)->get(['id']);
                $depensesToSearch = Depense::whereIn('entite_id', $entitesToSearch)->get(['id']);
                $queryDepenses = $queryDepenses->whereIn('depense_id', $depensesToSearch);
            }
            else
            {
                $queryDepenses = $queryDepenses->where('caisse_id', $item_id);
            }
            $queryDepenses = $queryDepenses->whereIn('mode_paiement_id', Modepaiement::where('paiement_cash', 1)->get(['id']));
            $queryDepenses = $queryDepenses->first();

            $retour = ($queryApprosReceveurs->total + $queryPaiementsComms->total + $queryLigneCredit->total) - ($queryApprosEmetteurs->total + $querySortieCashs->total + $queryDepenses->total);
        }
        return $retour;
    }


    public static function getHoursBydate($date)
    {
        $date_at = $date;
        if ($date_at !== null) {
            $date_at = $date_at;
            $date_at = date_create($date_at);

            return date_format($date_at,  "H:i:s" );
        } else {
            return null;
        }
    }

    public static function donnePrixRevient($parametres)
    {
        $retour = 0;
        $total = $parametres["total"]; //Prix de revient de la fiche technique
        $prix_de_revient_unitaire = $parametres["prix_de_revient_unitaire"]; //Prix de revient saisi manuellement
        $prix_achat_ttc = $parametres["prix_achat_ttc"]; //Prix achat ttc
        $prix_achat_unitaire = $parametres["prix_achat_unitaire"]; //Prix achat ht

        if($total > 0)
        {
            $retour = $total;
        }
        else if($prix_de_revient_unitaire > 0)
        {
            $retour = $prix_de_revient_unitaire;
        }
        else if($prix_achat_ttc > 0)
        {
            $retour = $prix_achat_ttc;
        }
        else if($prix_achat_unitaire > 0)
        {
            $retour = $prix_achat_unitaire;
        }

        return $retour;
    }

    //Récupérer les détails des éléments des états
    public static function rajouteElements($query, $itemArray, $table = null)
    {

        if((!empty($itemArray["entite_id"])))
        {
            if(isset($table))
            {
                if($table == 'encaissements')
                {
                    $query = $query->whereIn('caisse_id', Caisse::where('point_vente_id', $itemArray['entite_id'])->get(['id']));
                }
                if($table == 'commande_produits')
                {
                    $query = $query->where('commandes.point_vente_id', $itemArray["entite_id"]);

                }
            }
            else
            {
                $query = $query->where('commandes.point_vente_id', $itemArray["entite_id"]);
            }
        }
        if((!empty($itemArray["type_commande_id"])))
        {
            $query = $query->where('commandes.type_commande_id', $itemArray["type_commande_id"]);
        }
        if((!empty($itemArray["tranche_horaire_id"])))
        {
            if(isset($table)){
                if($table == 'commande_produits')
                {

                }else{

                    $query = $query->where('commandestranche_horaire_id', $itemArray["tranche_horaire_id"]);
                }
            }
        }
        if((!empty($itemArray["tranche_horaires"])))
        {
            //clocaisse_tranche_multiples
            $parametres = array(
                'query'                 => $query,
                'dateStart'             => $itemArray["date_debut"],
                'dateEnd'               => $itemArray["date_fin"],
                'tranche_horaires'      => $itemArray["tranche_horaires"],
                'table'                 => 'commandes',
                'columnDateName'        => 'date',
            );

         //$query = Outil::filterByTrancheHoraires($parametres);
           //dd($query->get());
        }
       // dd($query->get());
        return $query;
    }

    public static function Checkdetail($olddata, array $newdata, $model, $columns)
    {
        if (!is_array($columns))
        {
            $columns = array($columns);
        }
            foreach ($olddata as $onedetail) {

                $retour = false;
                foreach ($newdata as $value) {
                    $retour = true;
                    foreach ($columns as $keyColumn => $onecolumn) {
                        if(isset($value[$onecolumn])){
                            if ($onedetail->$onecolumn != $value[$onecolumn]) {
                                $retour = false;
                                break;
                            }
                        }
                    }
                    if ($retour) {
                        break;
                    }
                }
                if ($retour == false) {

                    $iem = app($model)::find($onedetail->id);
                    if ($iem) {
                        $iem->delete();
                        $iem->forceDelete();
                    }
                }
            }


    }

    public static function CheckImage($olddata, $newdata, $model, $columns)
    {
        $keys = array_keys($newdata);
        $produit_id =$olddata[0]["produit_id"];
        foreach ($olddata as $onedetail) {
            foreach ($keys as $key) {

            }
        }

        //dd($produit_id, $keys);

    }


    public static function getQrcode($id, $model, $titre)
    {
        $item = app($model)::find($id);
        if (!isset($item)) {
            $errors = $titre . " inexistant ";
            return response('{ "errors": "' . $errors . '" }')->header('Content-Type', 'application/json');
        } else {
            $name = $item->nom ?? $item->id;
            $code = $item->getTable() . '_' . $id;
            $pdf = PDF::loadView(
                'codebarre',
                [
                    'code'      => $code,
                    'titre'     => $titre,
                    'name'      => $name
                ]
            );
            return $pdf->stream();
        }
    }

    //Enregistrer une appro au cas ou on fait appel à lui
    public static function enregistrerApproCash($from = 'cloturecaisse', $itemParameter, $request = null)
    {
        $item = new ApproCash();
        $id = null;

        $user_id = Outil::donneUserId();

        if ($from == 'cloturecaisse')
        {
            if (isset($request))
            {
                if($itemParameter->total_reel_encaissement_cash > 0)
                {
                    $item->date = date('Y-m-d');
                    $item->montant = $itemParameter->total_reel_encaissement_cash;
                    $item->motif = $request->motif;
                    $item->caisse_source_id = $itemParameter->caisse_id;
                    $item->caisse_destinataire_id = $request->caisse_destinataire_id;
                    $item->cloture_caisse_id = $itemParameter->id;

                    $item->save();
                    $id = $item->id;
                }
            }
        }

        return $id;
    }

    //Enregistre la geolocalisation
    public static function enregistrerGeolocalisation($point_Vente_id = null)
    {
        $retour = null;
        $geolocalisation = null;
        $pointVente = null;
        if(isset($point_Vente_id))
        {
            //Récupérer le point de vente
            $pointVente = PointVente::find($point_Vente_id);
        }
        else
        {
            if (Auth::check())
            {
                //L'utilisateur est connecté
                $user_id = Auth::user()->id;
                $geolocalisateur = Auth::user()->geolocalisateur;
                if($geolocalisateur == 1)
                {
                    //Récupérer la geolocalisation
                    $geolocalisation = Outil::donneGeolocalisation();

                    //Récupérer le point de vente
                    $userPointVente = UserPointVente::where('user_id', $user_id)->first();
                    if(isset($userPointVente))
                    {
                        $pointVente = PointVente::where('id', $userPointVente->point_vente_id)->first();
                    }
                }
            }
        }

        //Mettre à jour la geolocalisation dans le point de vente
        if(isset($pointVente) && isset($geolocalisation))
        {
            $pointVente->geolocalisation = $geolocalisation;
            $pointVente->save();

            $historiqueGeolocalisation = new HistoriqueGeolocalisation();
            $historiqueGeolocalisation->geolocalisation = json_encode($geolocalisation);
            $historiqueGeolocalisation->latitude_geolocalisation = $geolocalisation["latitude"];
            $historiqueGeolocalisation->longitude_geolocalisation = $geolocalisation["longitude"];
            $historiqueGeolocalisation->point_vente_id = $pointVente->id;
            $historiqueGeolocalisation->user_id = Auth::user()->id;
            $historiqueGeolocalisation->save();

            $retour = true;
        }


        return $retour;
    }

    //Donne la geolocalisation
    public static function donneGeolocalisation()
    {
        $retour = null;
        $ip = Outil::donneIp();
        $data = \Location::get($ip);
        if(isset($data))
        {
            $dataArray = (array) $data;
            //Pour fixer sa propre localisation en guise de test
            /* $dataArray = array(
                "ip" => "154.124.232.131",
                "countryName" => "Senegal",
                "countryCode" => "SN",
                "regionCode" => "DK",
                "regionName" => "Dakar",
                "cityName" => "Dakar",
                "zipCode" => "",
                "isoCode" => null,
                "postalCode" => null,
                "latitude" => "14.684743903302355",
                "longitude" => "-17.458103681967653",
                "metroCode" => null,
                "areaCode" => "DK",
                "driver" => "Stevebauman\Location\Drivers\IpApi",
            ); */
            $dataArray["date"] = date('Y-m-d H:i:s');

            $retour = $dataArray;
        }
        return $retour;
    }

    //Donne l'adresse IP de l'utilisateur connecté
    public static function donneIp()
    {
        //Pour fixer sa propre localisation en guise de test
        //$retour = "154.124.232.131";
        $retour = \Request::ip();
        return $retour;
    }

    //Test si le point de vente à au moins un emplacement à une date
    public static function localisationExiste($point_vente_id, $date = null)
    {
        $retour = "Veuillez choisir au moins une localisation pour aujourdh'hui";
        if (empty($date))
        {
            $date = date('Y-m-d');
        }

        $query = HistoriqueGeolocalisation::where('point_vente_id', $point_vente_id)
        ->whereBetween('created_at', array($date.' 00:00:00', $date.' 23:59:59'))
        ->first();
        if(isset($query))
        {
            $retour = null;
        }

        return $retour;
    }

    //Donne l'état et la couleur du badge au niveau de la liste
    public static function donneEtatGeneral($type, $itemArray = null)
    {
        $retour = null;
        if ($type == "archive_be")
        {
            if (isset($itemArray)) {

                $archive       = $itemArray["archive"];

                if(!isset($archive) || $archive == 0){
                    $retour = array("text" => "NON","badge" => "success");
                }else{
                    $retour = array("text" => "OUI","badge" => 'danger');
                }
            }
        }
        if ($type == "commande_tag_departement")
        {
            $departement = '';
            if (isset($itemArray)) {
                if(isset($itemArray['id'])){
                    $historique = Historiqueaction::where('commande_id', $itemArray['id'])->where('action', 7)->orderBy('heure', 'DESC')->first();
                    if(isset($historique) && isset($historique->index_produit)){
                        $commandeproduit  = Commandeproduit::where('index', $historique->index_produit)->where('commande_id', $itemArray['id'])->first();
                        if(isset($commandeproduit)){
                            $produit          = Produit::find($commandeproduit->produit_id);
                            if(isset($produit->departement_id)){
                                $dept =Departement::find($produit->departement_id);
                                if(isset($dept)){
                                    $departement =  $dept->designation;
                                }
                            }
                        }

                    }else{
                        $departements  = Departement::query();
                        $departements = $departements
                            ->join('produits','produits.departement_id', 'departements.id')
                            ->whereIn('produits.id', Commandeproduit::where('direct', 1)->whereNull('action')->where('commande_id', $itemArray['id'])->get(['produit_id']))
                            ->groupBy(['departements.id'])
                            ->selectRaw('departements.*')->get();

                        if(isset($departements) && count($departements) > 0){

                            foreach ($departements as $key=>$val)
                            {
                                    if(isset($val)){
                                        $departement .=  $val->designation . ' ';
                                    }
                            }
                        }
                    }
                }
            }
            $retour = array("text" => $departement, "badge" => "bg-danger");
        }
        if ($type == "commande_tag_direct")
        {
            if (isset($itemArray)) {
                if(isset($itemArray['id'])){
                    $text_reserve = '';
                    $allcommandeproduit  = Commandeproduit::where('commande_id',$itemArray['id'])->count();
                    $commandeproduit     = Commandeproduit::where('commande_id',$itemArray['id'])->where('direct', 1)->count();
                    $alldirectfinish     = Commandeproduit::where('commande_id',$itemArray['id'])->where('direct', 1)->where('action', 4)->count();

                    if(isset($allcommandeproduit)){
                        if(isset($commandeproduit)){
                            if(isset($alldirectfinish)) {
                                if($allcommandeproduit == $commandeproduit){
                                    if($commandeproduit > 0){
                                        if(($commandeproduit  == $alldirectfinish)){
                                            $retour = array("text" => "Direct", "badge" => "bg-success");
                                        }else{
                                            $retour = array("text" => "Direct", "badge" => "bg-warning");
                                        }
                                    } else{
                                        $retour = array("text" => "", "badge" => "");
                                    }
                                }else{
                                    $retour = array("text" => "", "badge" => "");
                                }

                            }else{
                                $retour = array("text" => "", "badge" => "");
                            }
                        }else{
                            $retour = array("text" => "", "badge" => "");
                        }
                    }else{
                        $retour = array("text" => "", "badge" => "");
                    }


                }
            }
        }
        if ($type == "table_reservation")
        {
            $text_reserve = null;
            $badge = null;
            $etat = null;
            if (isset($itemArray)) {
                if(isset($itemArray['id'])){
                    $text_reserve = '';
                    $reservation = Reservation::query()
                        ->join('tables_reservations','tables_reservations.reservation_id', 'reservations.id')
                        ->join('tables','tables.id', 'tables_reservations.table_id')
                        ->where('tables.id', $itemArray['id'])->whereIn('etat', [0,1])->get();
                    //  var_dump($reservation);

                    if(isset($reservation) && count($reservation) > 0){
                        $text_reserve = 'Reservée le';
                        foreach ($reservation as $key=>$reserv){
                            $date_reservation = self::resolveAllDateCompletFR($reserv['date_reservation'], false);
                            $heure            = $reserv['heure_debut'];
                            $text_reserve .= ' '.$date_reservation.' à '.$heure. '/';
                        }
                        $badge = 'bg-danger';
                        $etat = 1;
                    }
                }
                $retour = array("text_reservation" =>$text_reserve, "badge_reserve"=> $badge, "reservation"=>$etat);
            }
        }
        if ($type == "echeance_recouvrement")
        {
            if (isset($itemArray)) {

                $date       = $itemArray["date"];
                $date_now   = now();
                $date_now   = explode(' ', $date_now);
                $date       = explode(' ', $date);
                if($date[0] < $date_now[0]){
                    $retour = array("badge" => "bg-danger");
                }else{
                    $retour = array("badge" => '');
                }
            }
        }
        if ($type == "famille")
        {
            if (isset($itemArray)) {
                $etat = $itemArray["etat"];
                if (!isset($etat) || $etat == 0) {
                    $retour = array("texte" => "non défini", "badge" => "bg-dark");
                } else if ($etat == 1) {
                    $retour = array("texte" => "Pour carte", "badge" => "bg-success");
                } else if ($etat == 2) {
                    $retour = array("texte" => "Pour menu", "badge" => "bg-success");
                }
            }
        }
        if ($type == "etat_general")
        {
            if (isset($itemArray)) {
                $etat = $itemArray["etat"];
                if ($etat == 0) {
                    $retour = array("texte" => "non", "badge" => "bg-danger");
                } else if ($etat == 1) {
                    $retour = array("texte" => "oui", "badge" => "bg-success");
                }
            }
        }
        else if ($type == "etat_action")
        {
            if (isset($itemArray)) {
                $dateAujourd8 = date('Y-m-d');
                $dateAction = $itemArray["dateAction"];
                $etat = $itemArray["etat"];

                if ($etat == 0) {
                    if ($dateAction > $dateAujourd8) {
                        $retour = array("texte" => "à venir", "badge" => "bg-success");
                    } else if ($dateAction < $dateAujourd8) {
                        $retour = array("texte" => "manqué", "badge" => "bg-danger");
                    } else if ($dateAction == $dateAujourd8) {
                        $retour = array("texte" => "jour-j", "badge" => "bg-info");
                    }
                } else if ($etat == 1) {
                    $retour = array("texte" => "effectué", "badge" => "bg-dark");
                }
            }
        } else if ($type == "conformite_action") {
            if (isset($itemArray)) {
                $conformite = $itemArray["conformite"];
                if ($conformite == 0) {
                    $retour = array("texte" => "non", "badge" => "bg-danger");
                } else if ($conformite == 1) {
                    $retour = array("texte" => "oui", "badge" => "bg-success");
                } else if ($conformite == 2) {
                    $retour = array("texte" => "en attente", "badge" => "bg-info");
                }
            }
        } else if ($type == "etat_cloturecaisse") {
            if (isset($itemArray)) {
                $etat = $itemArray["etat"];
                if ($etat == 0) {
                    $retour = array("texte" => "en attente", "badge" => "bg-info");
                } else if ($etat == 1) {
                    $retour = array("texte" => "clôturé", "badge" => "bg-success");
                }
            }
        } else if ($type == "manquant_cloturecaisse") {
            if (isset($itemArray)) {
                $manquant = $itemArray["manquant"];
                if ($manquant == 0) {
                    $retour = array("texte" => "non", "badge" => "bg-success");
                } else if ($manquant == 1) {
                    $retour = array("texte" => "oui", "badge" => "bg-danger");
                }
            }
        } else if ($type == "paiement_cash_modepaiement") {
            if (isset($itemArray)) {
                $paiement_cash = $itemArray["paiement_cash"];
                if ($paiement_cash == 0) {
                    $retour = array("texte" => "non", "badge" => "bg-dark");
                } else if ($paiement_cash == 1) {
                    $retour = array("texte" => "oui", "badge" => "bg-info");
                }
            }
        } else if ($type == "creation_from_cloture_approcash") {
            if (isset($itemArray)) {
                $cloture_caisse_id = $itemArray["cloture_caisse_id"];
                if (empty($cloture_caisse_id)) {
                    $retour = array("texte" => "non", "badge" => "bg-dark");
                } else {
                    $retour = array("texte" => "oui", "badge" => "bg-info");
                }
            }
        } else if ($type == "peut_versement_banque_typecaisse") {
            if (isset($itemArray)) {
                $peut_versement_banque = $itemArray["peut_versement_banque"];
                if ($peut_versement_banque == 0) {
                    $retour = array("texte" => "non", "badge" => "bg-danger");
                } else if ($peut_versement_banque == 1) {
                    $retour = array("texte" => "oui", "badge" => "bg-success");
                }
            }
        } else if ($type == "commande" || $type == "historique_action_commande" || $type == "commande_produit") {
            if (isset($itemArray)) {
                $status = $itemArray["etat"];
                if ($status == 1) {
                    $retour = array("texte" => "Commande initiée", "badge" => "bg-info");
                } else if ($status == 2) {
                    $retour = array("texte" => "Commande validée", "badge" => "bg-success");
                } else if ($status == 3) {
                    $retour = array("texte" => "En préparation", "badge" => "bg-warning");
                } else if ($status == 4) {
                    $retour = array("texte" => "Terminée", "badge" => "bg-success");
                } else if ($status == 5) {
                    $retour = array("texte" => "Livrée", "badge" => "bg-success");
                } else if ($status == 6) {
                    $retour = array("texte" => "Annulée", "badge" => "bg-danger");
                }
                else if ($status == 8) {
                    $retour = array("texte" => "Cloturée", "badge" => "bg-danger");
                }
            }
        } else if ($type == "bt") {
            if (isset($itemArray)) {
                $status = $itemArray["etat"];

                if (!isset($status) || $status == 0) {
                    $retour = array("texte" => "En attente de validation", "badge" => "bg-danger");
                } else if ($status == 1) {
                    $retour = array("texte" => "Validé", "badge" => "bg-success");
                }


            }
        } else if ($type == "proforma") {
            if (isset($itemArray)) {
                $status = $itemArray["etat"];
                if ($status == 0) {
                    $retour = array("texte" => "En attente de validation", "badge" => "bg-info");
                }
                if ($status == -1) {
                    $retour = array("texte" => "En attente de proposition", "badge" => "bg-warning");
                }
                if ($status == 1) {
                    $date = now();

                    if($itemArray["date"] >  $date){
                        $retour = array("texte" => "Traiteur à venir", "badge" => "bg-primary");

                    }else{
                        $retour = array("texte" => "Traiteur en cours", "badge" => "bg-success");

                    }
                }
                if ($status == 2) {
                    $retour = array("texte" => "Traiteur cloturé", "badge" => "bg-danger");
                }


            }
        }
        else if ($type == "etat_depense")
        {
            if (isset($itemArray)) {
                $etat = $itemArray["etat"];
                if ($etat == 0) {
                    $retour = array("texte" => "en attente", "badge" => "bg-info");
                } else if ($etat == 1) {
                    $retour = array("texte" => "validé", "badge" => "bg-success");
                } else if ($etat == 2) {
                    $retour = array("texte" => "non validé", "badge" => "bg-danger");
                }
            }
        }
        else if ($type == "payer_depense")
        {
            if (isset($itemArray)) {
                $payer = $itemArray["payer"];
                if ($payer == 0) {
                    $retour = array("texte" => "non", "badge" => "bg-danger");
                } else if ($payer == 1) {
                    $retour = array("texte" => "oui", "badge" => "bg-success");
                } else if ($payer == 2) {
                    $retour = array("texte" => "partiel", "badge" => "bg-warning");
                }
            }
        }
        else if ($type == "reception_bce")
        {
            if (isset($itemArray)) {
                $reception = $itemArray["reception"];
                if ($reception == 0) {
                    $retour = array("texte" => "non", "badge" => "bg-danger");
                } else if ($reception == 1) {
                    $retour = array("texte" => "cloturé", "badge" => "bg-success");
                } else if ($reception == 2) {
                    $retour = array("texte" => "partiel", "badge" => "bg-warning");
                }
            }
        }
        else if ($type == "payer_be")
        {
            if (isset($itemArray)) {
                $payer = $itemArray["payer"];
                if ($payer == 0) {
                    $retour = array("texte" => "Dépense non créee",   "badge" => "danger");
                } else if ($payer == 1) {
                    $retour = array("texte" => "Aucun paiement",      "badge" => "dark");
                } else if ($payer == 2) {
                    $retour = array("texte" => "Partiellement payé",  "badge" => "warning");
                } else if ($payer == 3) {
                    $retour = array("texte" => "Totalement payé",     "badge" => "success");
                }
            }
        }
        else if ($type == "etat_facture")
        {
            if (isset($itemArray)) {
                $etat = $itemArray["etat"];
                if ($etat == 0) {
                    $retour = array("texte" => "en attente", "badge" => "bg-info");
                } else if ($etat == 1) {
                    $retour = array("texte" => "validé", "badge" => "bg-success");
                } else if ($etat == -1) {
                    $retour = array("texte" => "non validé", "badge" => "bg-danger");
                }
            }
        }
        else if ($type == "payer_facture")
        {
            if (isset($itemArray)) {
                $payer = $itemArray["payer"];
                if ($payer == 0) {
                    $retour = array("texte" => "non", "badge" => "bg-danger");
                } else if ($payer == 1) {
                    $retour = array("texte" => "oui", "badge" => "bg-success");
                } else if ($payer == 2) {
                    $retour = array("texte" => "partiel", "badge" => "bg-warning");
                }
            }
        }
        else if ($type == "suivimarketing") {
            if (isset($itemArray)) {
                $etat = $itemArray["etat"];
                if ($etat == 0) {
                    $retour = array("texte" => "non validé", "badge" => "bg-info");
                } else if ($etat == -1) {
                    $retour = array("texte" => "rejeté", "badge" => "bg-danger");
                } else if ($etat == 1) {
                    $retour = array("texte" => "validé", "badge" => "bg-success");
                }
                else if ($etat == 2) {
                    $retour = array("texte" => "archivée", "badge" => "bg-warning");
                }
                else{
                    $retour = array("texte" => "non validé", "badge" => "bg-info");
                }
            }else{
                $retour = array("texte" => "non validé", "badge" => "bg-info");
            }
        }
        else if ($type == "tagclient") {
            if (isset($itemArray)) {
                $etat = $itemArray["etat"];
                if ($etat == 1) {
                    $retour = array("texte" => "en cours", "badge" => "bg-success");
                }else if($etat == 2){
                    $retour = array("texte" => "archivé", "badge" => "bg-danger");
                }else{
                    $retour = array("texte" => "", "badge" => "");
                }
            }
        }
        else if ($type == "compta_general")
        {
            if (isset($itemArray))
            {
                $compta = $itemArray["compta"];
                if ($compta == 0) {
                    $retour = array("texte" => "non", "badge" => "bg-success");
                } else if ($compta == 1) {
                    $retour = array("texte" => "oui #1", "badge" => "bg-danger");
                } else if ($compta == 2) {
                    $retour = array("texte" => "oui #2", "badge" => "bg-danger");
                }
            }
        }
        else if ($type == "activer_employe")
        {
            if (isset($itemArray)) {
                $activer = $itemArray["activer"];
                if ($activer == 0) {
                    $retour = array("texte" => "non", "badge" => "bg-danger");
                } else if ($activer == 1) {
                    $retour = array("texte" => "oui", "badge" => "bg-success");
                }
            }
        }
        else if ($type == "reservation")
        {
            if (isset($itemArray)) {
                $activer = $itemArray["etat"];
                if (!$activer || $activer == 0) {
                    $retour = array("texte" => "initiée", "badge" => "bg-danger");
                } else if ($activer == 1) {
                    $retour = array("texte" => "en cours", "badge" => "bg-success");
                }
                else if ($activer == 2) {
                    $retour = array("texte" => "Terminée", "badge" => "bg-success");
                }
            }
        }

        else if ($type == "date_echeance_depense")
        {
            if (isset($itemArray)) {
                $date_echeanche = $itemArray["date_echeance"];
                $date  = now();
                $date   = explode(' ', $date);
                $date_at = self::resolveAllDateCompletFR($date_echeanche, false);
                $date_echeanche   = explode(' ', $date_echeanche);
                if($date_echeanche[0] >= $date[0]){
                    $retour = array("texte" => $date_at, "badge" => "bg-success");
                }else{
                    $retour = array("texte" => $date_at, "badge" => "bg-danger");
                }

            }
        }
        if ($type == "etat_compte_credit")
        {
            if (isset($itemArray)) {
                $etat = $itemArray["etat"];

                if ($etat == 1) {
                    $retour = array("texte" => "En cours", "badge" => "bg-success");
                } else if ($etat == 2) {
                    $retour = array("texte" => "Expiré", "badge" => "bg-danger");
                }
                else if ($etat == 0) {
                    $retour = array("texte" => "Desactivé", "badge" => "bg-danger");
                }

            }
        }

        return $retour;
    }

    //Valorisation manquant inventaire
    public static function valorisationManquantInventaireTTC($item_id,$type)
    {
        $retour = 0;
        $inventaire         = Inventaire::find($item_id);
        $produit_manquant   = Inventaireproduit::query()->where('inventaire_id', $item_id)
                                                        ->where('perte_neglisable','!=', 1)
                                                       // ->where('quantite_reel','<', 'quantite_theorique')
                                                        ->selectRaw('inventaire_produits.*, ABS(quantite_reel - quantite_theorique) as diff')
                                                        ->get();


        if(isset($inventaire) && isset($inventaire->depot_id))
        {
            $depot         = Depot::find($inventaire->depot_id);
        }

        if(isset($produit_manquant) && count($produit_manquant) > 0){

            if(isset($depot))
            {
                $test  = '';
                foreach ($produit_manquant as $key=>$prod)
                {
                    if($prod->quantite_reel < $prod->quantite_theorique)
                    {

                        $inventaire_produit  = Inventaireproduit::find($prod->id);
                        $inventaire_produit->is_perte = 1;
                        $inventaire_produit->save();
                        //dd($prod->prix);
                        $retour  += self::getValorisationTTC($depot, $prod->produit_id, $prod->diff,$type,$prod->prix);
                    }
                }
            }

        }
    //dd($retour);
    return round($retour);
    }


    public static function valorisationSurplus($item_id,$type)
    {
        $retour = 0;
        $inventaire         = Inventaire::find($item_id);
        $produit_manquant   = Inventaireproduit::query()->where('inventaire_id', $item_id)
                                                        ->whereNull('inventaire_produits.is_perte')
                                                        // ->where('quantite_theorique','<', 'quantite_reel')
                                                        ->selectRaw('inventaire_produits.*, ABS(quantite_reel - quantite_theorique) as diff')
                                                        ->get();

        if(isset($inventaire) && isset($inventaire->depot_id)){
            $depot         = Depot::find($inventaire->depot_id);
        }


        if(isset($produit_manquant) && count($produit_manquant) > 0)
        {
            if(isset($depot))
            {
                $test  = '';
                foreach ($produit_manquant as $key=>$prod){

                    if($prod->quantite_theorique < $prod->quantite_reel){
                        $inventaire_produit  = Inventaireproduit::find($prod->id);
                        $inventaire_produit->is_perte = null;
                        $inventaire_produit->save();
                        //var_dump($prod->diff);
                        $retour  += self::getValorisationTTC($depot, $prod->produit_id, $prod->diff,$type,$prod->prix);
                    }
                }
            }

        }
      //  var_dump($test);
        return round($retour);
    }

    public static function valorisation($item_id,$type)
    {
        $retour = 0;
        $inventaire         = Inventaire::find($item_id);
        $produit_manquant   = Inventaireproduit::query()->where('inventaire_id', $item_id)
                                                        // ->whereNull('inventaire_produits.is_perte')
                                                        // ->where('quantite_theorique','<', 'quantite_reel')
                                                        ->selectRaw('inventaire_produits.*')
                                                        ->get();

        if(isset($inventaire) && isset($inventaire->depot_id)){
            $depot         = Depot::find($inventaire->depot_id);
        }


        if(isset($produit_manquant) && count($produit_manquant) > 0){
            if(isset($depot)){
                $test  = '';
                foreach ($produit_manquant as $key=>$prod){
                        $retour  += self::getValorisationTTC($depot, $prod->produit_id, $prod->quantite_reel,$type,$prod->prix);
                }
            }

        }
      //  var_dump($test);
        return round($retour);
    }
    public static function getValorisationTTC($depot, $id_prod, $diff, $type,$prixold)
    {
        $retour = 0;

        $type_depot = $depot->type_depot;
        $entite     = $depot->entite;
        if(isset($depot) && isset($depot->id)){
            $produit = Produit::find($id_prod);
            if(isset($produit) && isset($produit->id)){
                $nomenclature = $produit->nomenclature;

                $solde        = Nomenclature::solide()->nom;
                $liquide      = Nomenclature::liquide()->nom;
                $stockage     = TypeDepot::stockage()->nom;


                if(isset($nomenclature) && isset($nomenclature->id)){

                    if($nomenclature->nom == $solde || ($nomenclature->nom == $liquide && $type_depot->nom == $stockage)){

                        //dd($solde, $type_depot);

                        $prix = 0;

                        if(isset($prixold))
                        {
                            $prix = $prixold;
                        }
                        else
                        {

                            if($type == 'ttc')
                            {
                                if($produit->pa_ttc  > 0)
                                {
                                    $prix = $produit->pa_ttc;
                                }
                            }
                            else if($type  == 'ht')
                            {
                                if($produit->prix_unitaire > 0 )
                                {
                                    $prix = $produit->prix_unitaire;
                                }

                            }
                        }


                        $retour   = $diff * $prix;

                    }else if($nomenclature->designation == $liquide){
                        // if(isset($entite) && isset($entite->id)){
                        //     $prix_vente = DB::table('prix_de_ventes')
                        //         ->join('type_prix_de_ventes', 'type_prix_de_ventes.id', '=', 'prix_de_ventes.type_prix_de_vente_id')
                        //         ->join('produits', 'produits.id', '=', 'prix_de_ventes.produit_id')
                        //         ->where('type_prix_de_ventes.designation', Outil::getOperateurLikeDB(), '%' . $entite->designation . '%')
                        //         ->selectRaw("prix_de_ventes.*")
                        //         ->first();
                        //     if(isset($prix_vente) && isset($prix_vente->id) && isset($prix_vente->montant)){
                        //         $retour   = $diff * $prix_vente->montant;
                        //     }
                        // }

                    }
                }
            }
        }

        return round($retour);
    }

    //Donne le total des paiements
    public static function donneTotalPaiement($from = "depense", $itemId, $typefacture = 'restau')
    {
        $retour = 0;

        if (isset($itemId))
        {
            $query = DB::table("paiements")->select(DB::raw("COALESCE(SUM(montant),0) as total"));
            if ($from == "depense")
            {
                $query = $query->where('depense_id', $itemId);
            }
            else if ($from == "paiement")
            {
                $query = $query->where('commande_id', $itemId);
            }
            else if ($from == "facture")
            {
                if($typefacture  == 'restau'){
                    $query = $query->whereIn('commande_id', DetailFacture::where('facture_id', $itemId)->get(['commande_id']));
                } else if($typefacture  == 'traiteur'){
                    $query = $query->where('facture_id', $itemId);
                }

            }
            else if ($from == "be")
            {
                $query = $query->whereIn('depense_id', Depense::where('bon_entree_id', $itemId)->get(['id']));
            }

            $retour = $query->first()->total;
        }

        return isset($retour) ? round($retour) : $retour;
    }

    public static function donneProduitsCommande($parametres, $type = 'vente',$menu=false)
    {
        $dateStart          = isset($parametres["dateStart"])    ? $parametres["dateStart"]  : null;
        $dateEnd            = isset($parametres["dateEnd"])      ? $parametres["dateEnd"]    : null;
        $caisseId           = isset($parametres["caisseId"])     ? $parametres["caisseId"]   : null;
        $permission         = isset($parametres["permission"])   ? $parametres["permission"] : null;

        $heure_debut        = isset($parametres["heure_debut"])   ? $parametres["heure_debut"] : null;
        $heure_fin          = isset($parametres["heure_fin"])   ? $parametres["heure_fin"] : null;

        $point_vente_id     = isset($parametres["point_vente_id"])   ? $parametres["point_vente_id"] : null;
        $client_id          = isset($parametres["client_id"])   ? $parametres["client_id"] : null;
        $type_commande_id   = isset($parametres["type_commande_id"])   ? $parametres["type_commande_id"] : null;
        $table_id           = isset($parametres["table_id"])   ? $parametres["table_id"] : null;
        $commande_id        = isset($parametres["commande_id"])   ? $parametres["commande_id"] : null;

        $etat_commande      = isset($parametres["etat_commande"])   ? $parametres["etat_commande"] : null;
        $etat_paiement      = isset($parametres["etat_paiement"])   ? $parametres["etat_paiement"] : null;
        $perte              = isset($parametres["perte"])   ? $parametres["perte"] : null;
        $client_passage     = isset($parametres["client_passage"])   ? $parametres["client_passage"] : null;
        $tranche_horaire_id = isset($parametres["tranche_horaire_id"])   ? $parametres["tranche_horaire_id"] : null;
        $type_client_id     = isset($parametres["type_client_id"])   ? $parametres["type_client_id"] : null;
        $mode_paiement_id   = isset($parametres["mode_paiement_id"])   ? $parametres["mode_paiement_id"] : null;
        $famille_id         = isset($parametres["famille_id"])   ? $parametres["famille_id"] : null;

        if (empty($dateStart) || empty($dateEnd))
        {
            $trancheHoraireEnCours  = Outil::donneTrancheHoraire();
            if(isset($trancheHoraireEnCours))
            {
                $dateToday          = date('Y-m-d');
                $heureStart         = substr($trancheHoraireEnCours->heure_debut, 11, 5);
                $heureEnd           = substr($trancheHoraireEnCours->heure_fin, 11, 5);
                $dateStart          = $dateToday;
                $dateEnd            = $dateToday;
            }
        }

        if (isset($dateStart) || isset($dateEnd))
        {
            if(!isset($heure_debut) || !isset($heure_fin)){
                if(isset($tranche_horaire_id)){
                    $tranche_horaire     = Tranchehoraire::find($tranche_horaire_id);

                    $heure_debut = Carbon::parse($tranche_horaire->heure_debut)->format('H:i:s');
                    $heure_fin   = Carbon::parse($tranche_horaire->heure_fin)->format('H:i:s');
                }else{
                    $heure_debut  = '00:00:00';
                    $heure_fin    = '23:59:59';
                }

            }else{

               // $heure_debut  = $heure_debut.':00';
                //$heure_fin    = $heure_fin.':59';

            }

            if($heure_debut > $heure_fin){
                if($dateStart == $dateEnd){
                    $dateEnd = date('Y-m-d', strtotime($dateEnd. ' + 1 days'));
                }
            }

            $dateStart        = $dateStart .' '.$heure_debut;
            $dateEnd          = $dateEnd.' '.$heure_fin;
        }

        if (empty($caisseId))
        {
            $caisseUserConnected = Outil::donneCaisseUser();
            $caisseId = isset($caisseUserConnected) ? $caisseUserConnected : null;
        }

        $query = CommandeProduit::query()
            ->join('produits', 'produits.id', '=', 'commande_produits.produit_id')
            ->join('commandes', 'commandes.id', '=', 'commande_produits.commande_id')
            ->whereNull('commande_produit_id');

        if($type !=='conso'){
            $query = $query->whereNotIn('commandes.c_interne',[1,2]);
        }else{
            $query = $query->where('commandes.c_interne',1);
        }
        if (isset($tranche_horaire_id)) {
            $query              = $query->where('commandes.tranche_horaire_id', $tranche_horaire_id);
        }


        if (isset($famille_id)) {

            //dd($famille_id);
            $query              = $query
                ->join('famille_produits','famille_produits.id','produits.famille_produit_id')
                ->where('famille_produits.id', $famille_id);
        }
        if ($menu==true) {

            $query              = $query
                ->whereNull('produits.famille_produit_id');
        }

        if (isset($mode_paiement_id)) {
            $query      = $query->whereIn('commandes.id', Paiement::whereNotNull('commande_id')->where('mode_paiement_id', $mode_paiement_id)->get(['commande_id']));
        }
        if (isset($type_client_id))
        {
            $query = $query
                ->whereIn('commandes.client_id', Client::where('type_client_id', $type_client_id)
                    ->get(["id"]));

        }
        if ((!empty($dateStart)) && (!empty($dateEnd)))
        {

            // dd($dateStart,$dateEnd);
            // dd("ici",$query->get());
            $query->whereBetween('commandes.date', array($dateStart,$dateEnd));
            if (isset($menu)) {


            }

            if((!empty($caisseId)))
            {
                $caisse = Caisse::find($caisseId);
                if(isset($caisse->point_vente_id) && isset($caisse->point_vente_id))
                {
                    $query->where('commandes.point_vente_id',$caisse->point_vente_id);
                }
                else
                {
                    $query->where('commandes.point_vente_id',null);
                }
            }
        }

        if($permission =='list-commande-departement' || $permission=="list-commande-encour" || $permission=="list-commande"){
            $date   = now();
            $date   = explode(' ', $date);

            $query  = $query->where('commandes.etat_commande', '!=', 8);
        }

        if (isset($point_vente_id)) {
           // dd($point_vente_id);
            $query = $query->where('commandes.point_vente_id', $point_vente_id);
        }
        if (isset($client_id)) {
            $query = $query->where('commandes.client_id', $client_id);
        }
        if (isset($type_commande_id)) {
            $query = $query->where('commandes.type_commande_id', $type_commande_id);
        }
//        if (isset($table_id)) {
//            $query = $query->whereIn('commandes.id', CommandeTable::where('table_id', $table_id)->get(['commande_id']));
//        }
        if (isset($commande_id)) {
            $query = $query->where('commandes.id', $commande_id);
        }
        if (isset($etat_paiement))
        {
            if($etat_paiement == 0){
                $query = $query->where('commandes.montant_total_paye', '=',0);
            }else if($etat_paiement == 1){
                $query = $query->where('commandes.montant_total_paye', '>',0);
                $query = $query->where('commandes.restant_payer', '>',0);
            }

            else if($etat_paiement == 2){
                $query = $query->where('restant_payer', '=',0);
            }
        }
        if (isset($etat_commande)) {
            if($etat_commande == 0){
                $query = $query->where('commandes.etat_commande', '<', 4);
            }else{
                $query = $query->where('commandes.etat_commande', $etat_commande);
            }
        }
        if (isset($perte)) {
            $query = $query->where('commandes.perte', 1);
        }
        if (isset($client_passage)) {
            $query     = $query->whereNull('commandes.client_id');
        }

        if($type !=='perte'){
            $query = $query
                ->where('commande_produits.perte', '!=', 1);
        }else{
            $query = $query
                ->where('commande_produits.perte', 1);
        }

        if($type !=='offert'){

            $query = $query->where('commande_produits.offert', '!=', 1);
        }else{

            $query = $query->where('commande_produits.offert', 1);
        }

        $query = $query->groupBy(['commande_produits.produit_id','produits.designation'])

        ->selectRaw('COALESCE(SUM(commande_produits.total),0) as montant,
                               count(commande_produits.produit_id) as quantite,
                               produits.designation as designation,
                               commande_produits.produit_id as id');
        return  $query->get();
    }

    public static function donneFamillesCommande($parametres, $type = 'vente')
    {
        $dateStart          = isset($parametres["dateStart"])    ? $parametres["dateStart"]  : null;
        $dateEnd            = isset($parametres["dateEnd"])      ? $parametres["dateEnd"]    : null;
        $caisseId           = isset($parametres["caisseId"])     ? $parametres["caisseId"]   : null;
        $permission         = isset($parametres["permission"])   ? $parametres["permission"] : null;

        $heure_debut        = isset($parametres["heure_debut"])   ? $parametres["heure_debut"] : null;
        $heure_fin          = isset($parametres["heure_fin"])   ? $parametres["heure_fin"] : null;

        $point_vente_id     = isset($parametres["point_vente_id"])   ? $parametres["point_vente_id"] : null;
        $client_id          = isset($parametres["client_id"])   ? $parametres["client_id"] : null;
        $type_commande_id   = isset($parametres["type_commande_id"])   ? $parametres["type_commande_id"] : null;
        $table_id           = isset($parametres["table_id"])   ? $parametres["table_id"] : null;
        $commande_id        = isset($parametres["commande_id"])   ? $parametres["commande_id"] : null;

        $etat_commande      = isset($parametres["etat_commande"])   ? $parametres["etat_commande"] : null;
        $etat_paiement      = isset($parametres["etat_paiement"])   ? $parametres["etat_paiement"] : null;
        $perte              = isset($parametres["perte"])   ? $parametres["perte"] : null;
        $client_passage     = isset($parametres["client_passage"])   ? $parametres["client_passage"] : null;
        $tranche_horaire_id = isset($parametres["tranche_horaire_id"])   ? $parametres["tranche_horaire_id"] : null;
        $type_client_id     = isset($parametres["type_client_id"])   ? $parametres["type_client_id"] : null;
        $mode_paiement_id   = isset($parametres["mode_paiement_id"])   ? $parametres["mode_paiement_id"] : null;
        $famille_id         = isset($parametres["famille_id"])   ? $parametres["famille_id"] : null;

        // if (empty($dateStart) || empty($dateEnd))
        // {
        //     $trancheHoraireEnCours  = Outil::donneTrancheHoraire();
        //     if(isset($trancheHoraireEnCours))
        //     {
        //         $dateToday          = date('Y-m-d');
        //         $heureStart         = substr($trancheHoraireEnCours->heure_debut, 11, 5);
        //         $heureEnd           = substr($trancheHoraireEnCours->heure_fin, 11, 5);
        //         $dateStart          = $dateToday;
        //         $dateEnd            = $dateToday;
        //     }
        // }

        if (isset($dateStart) || isset($dateEnd))
        {
            if(!isset($heure_debut) || !isset($heure_fin))
            {
                if(isset($tranche_horaire_id))
                {
                    $tranche_horaire     = Tranchehoraire::find($tranche_horaire_id);

                    $heure_debut = Carbon::parse($tranche_horaire->heure_debut)->format('H:i:s');
                    $heure_fin   = Carbon::parse($tranche_horaire->heure_fin)->format('H:i:s');
                }
                else
                {
                    $heure_debut  = '00:00:00';
                    $heure_fin    = '23:59:59';
                }

            }
            else
            {

                // $heure_debut  = $heure_debut.':00';
                // $heure_fin    = $heure_fin.':59';

            }

            if($heure_debut > $heure_fin)
            {
                if($dateStart == $dateEnd)
                {
                    $dateEnd = date('Y-m-d', strtotime($dateEnd. ' + 1 days'));
                }
            }

            $dateStart        = $dateStart .' '.$heure_debut;
            $dateEnd          = $dateEnd.' '.$heure_fin;
        }

        if (empty($caisseId))
        {
            $caisseUserConnected = Outil::donneCaisseUser();
            $caisseId = isset($caisseUserConnected) ? $caisseUserConnected : null;
        }

        $query = FamilleProduit::query()
            ->join('produits','produits.famille_produit_id','famille_produits.id')
            ->join('commande_produits', 'commande_produits.produit_id', '=', 'produits.id')
            ->join('commandes', 'commandes.id', '=', 'commande_produits.commande_id');
            // ->groupBy(['famille_produits.id'])
            // ->selectRaw('COALESCE(SUM(commande_produits.prix),0) as montant,
            //                        count(commande_produits.produit_id) as quantite,
            //                        famille_produits.nom as designation,
            //                        famille_produits.id as id');
            //dd($query->get() );
//        if($type !=='conso'){
//            $query = $query->whereNotIn('commandes.c_interne',[1,2]);
//        }else{
//            $query = $query->where('commandes.c_interne',1);
//        }
        // if (!isset($dateStart) && !isset($dateEnd))
        // {
            if (isset($tranche_horaire_id)) {
                $query              = $query->where('commandes.tranche_horaire_id', $tranche_horaire_id);
            }
        //}


        if (isset($famille_id)) {
            $query              = $query
                ->where('produits.famille_produit_id', $famille_id);
        }

        if (isset($mode_paiement_id)) {
            $query      = $query->whereIn('commandes.id', Paiement::whereNotNull('commande_id')->where('mode_paiement_id', $mode_paiement_id)->get(['commande_id']));
        }
        if (isset($type_client_id))
        {
            $query = $query
                ->whereIn('commandes.client_id', Client::where('type_client_id', $type_client_id)
                    ->get(["id"]));

        }
        if ((!empty($dateStart)) && (!empty($dateEnd)))
        {

        //dd($dateStart,$dateEnd);

            $query->whereBetween('commandes.date', array($dateStart,$dateEnd));

            if((!empty($caisseId)))
            {
                $caisse = Caisse::find($caisseId);
                if(isset($caisse->point_vente_id) && isset($caisse->point_vente_id))
                {
                    $query->where('commandes.point_vente_id',$caisse->point_vente_id);
                }
                else
                {
                    $query->where('commandes.point_vente_id',null);
                }
            }
        }

        if($permission =='list-commande-departement' || $permission=="list-commande-encour" || $permission=="list-commande"){
            $date   = now();
            $date   = explode(' ', $date);

            $query  = $query->where('commandes.etat_commande', '!=', 8);
        }

        if (isset($point_vente_id)) {
            // dd($point_vente_id);
            $query = $query->where('commandes.point_vente_id', $point_vente_id);
        }
        if (isset($client_id)) {
            $query = $query->where('commandes.client_id', $client_id);
        }
        if (isset($type_commande_id)) {
            $query = $query->where('commandes.type_commande_id', $type_commande_id);
        }
//        if (isset($table_id)) {
//            $query = $query->whereIn('commandes.id', CommandeTable::where('table_id', $table_id)->get(['commande_id']));
//        }
        if (isset($commande_id)) {
            $query = $query->where('commandes.id', $commande_id);
        }
        if (isset($etat_paiement))
        {
            if($etat_paiement == 0){
                $query = $query->where('commandes.montant_total_paye', '=',0);
            }else if($etat_paiement == 1){
                $query = $query->where('commandes.montant_total_paye', '>',0);
                $query = $query->where('commandes.restant_payer', '>',0);
            }

            else if($etat_paiement == 2){
                $query = $query->where('restant_payer', '=',0);
            }
        }
        if (isset($etat_commande)) {
            if($etat_commande == 0){
                $query = $query->where('commandes.etat_commande', '<', 4);
            }else{
                $query = $query->where('commandes.etat_commande', $etat_commande);
            }
        }
        if (isset($perte)) {
            $query = $query->where('commandes.perte', 1);
        }
        if (isset($client_passage)) {
            $query     = $query->whereNull('commandes.client_id');
        }

//        if($type !=='perte'){
//            $query = $query
//                ->where('commande_produits.perte', '!=', 1);
//        }else{
//            $query = $query
//                ->where('commande_produits.perte', 1);
//        }
//
//        if($type !=='offert'){
//            $query = $query->where('commande_produits.offert', '=', false);
//        }else{
//            $query = $query->where('commande_produits.offert', true);
//        }
        $query = $query->groupBy(['famille_produits.id'])
            ->selectRaw('COALESCE(SUM(commande_produits.prix),0) as montant,
                                   count(commande_produits.produit_id) as quantite,
                                   famille_produits.nom as designation,
                                   famille_produits.id as id');
        return  $query->get();
    }

    //Donne total dépense
    public static function donneTotalDepense($params = null,$nonValides = false)
    {
        $date_start      = null;
        $date_end        = null;
        $date_end        = null;
        $collumn         = 'date';
        $entite_id       = null;
        $caisse_id       = null;
        $fournisseur_id  = null;
        $motif           = null;
        $poste_depense_id= null;

        $etat             =null;
        $compta           = null;
        $echu             =null;
        $payer            =null;


        if(isset($params)){
            $date_start       = isset($params['date_debut']) ? $params["date_debut"] : null;
            $date_end         = isset($params['date_fin'])   ? $params["date_fin"] : null;
            $date_saisie      = isset($params['date_saisie'])? $params["date_saisie"] : null;

            $entite_id        = isset($params['entite_id'])  ? $params["entite_id"] : null;
            $caisse_id        = isset($params['caisse_id'])  ? $params["caisse_id"] : null;
            $fournisseur_id   = isset($params['fournisseur_id'])  ? $params["fournisseur_id"] : null;
            $motif            = isset($params['motif'])  ? $params["motif"] : null;
            $poste_depense_id = isset($params['poste_depense_id'])  ? $params["poste_depense_id"] : null;

            $etat             = isset($params['etat'])      ? $params["etat"] : null;
            $compta           = isset($params['compta'])  ? $params["compta"] : null;
            $echu             = isset($params['echu'])  ? $params["echu"] : null;
            $payer            = isset($params['payer'])  ? $params["payer"] : null;

            $heure_debut        = isset($params["heure_debut"])   ? $params["heure_debut"] : null;
            $heure_fin          = isset($params["heure_fin"])   ? $params["heure_fin"] : null;

            $tranche_horaire_id= isset($params['tranche_horaire_id'])? $params["tranche_horaire_id"] : null;


            if(isset($date_saisie)){
                if($date_saisie == 2)
                {
                    $collumn = 'date_piece';
                }
            }
        }
        $retour = 0;
        //$queryTotal = DB::table("depenses")->select(DB::raw("COALESCE(SUM(montant),0) as total"));
        $queryTotal = Paiement::query()->join('depenses', 'depenses.id', 'paiements.depense_id');


        if ($nonValides == true)
        {
            $queryTotal = $queryTotal->where('etat', 0);
        }

        if (isset($date_start) && isset($date_end))
        {
            if(!isset($heure_debut) && !isset($heure_fin))
            {
                $from = date($date_start . ' 00:00:00');
                $to = date($date_end . ' 23:59:59');
            }
            else
            {
                //dd($heure_debut);
                $from = date($date_start . ' '. $heure_debut);
                $to = date($date_end . ' '.$heure_fin);
            }
            //dd($from, $to);

            $queryTotal = $queryTotal->whereBetween('paiements.date', array($from, $to));
        }
        if (isset($caisse_id))
        {
            $queryTotal = $queryTotal->where('depenses.caisse_id', $caisse_id);
        }
        if (isset($tranche_horaire_id))
        {
            $queryTotal = $queryTotal->whereRaw("(paiements.heure BETWEEN ? AND ?) ",[$heure_debut,$heure_fin]);
        }
        if (isset($entite_id))
        {
            $queryTotal = $queryTotal->where('depenses.entite_id', $entite_id);
        }
        if (isset($fournisseur_id))
        {
            $queryTotal = $queryTotal->where('depenses.fournisseur_id', $fournisseur_id);
        }
        if (isset($motif))
        {
            $queryTotal = $queryTotal->where('depenses.motif', Outil::getOperateurLikeDB(), '%' . $motif . '%');
        }
        if (isset($poste_depense_id))
        {
            $queryTotal = $queryTotal->whereIn('depenses.id', DepensePosteDepense::where('poste_depense_id', $poste_depense_id)->get(['depense_id']));
        }
        if (isset($etat))
        {
            $queryTotal = $queryTotal->where('depenses.etat', $etat);
        }
//        if (isset($compta))
//        {
//            $queryTotal = $queryTotal->where('depenses.compta', $compta);
//        }
        if (isset($echu))
        {
            $date  = now();
            $date   = explode(' ', $date);

            if($echu == 1){
                $queryTotal = $queryTotal->where('depenses.date_echeance','<', $date[0]);

            }else{
                $queryTotal = $queryTotal->where('depenses.date_echeance','>=',  $date[0]);
            }
        }
        if (isset($payer))
        {
            if($payer == 0)
            {
                //Solde non
                $queryTotal = $queryTotal->whereRaw("((select ROUND(COALESCE(SUM(p.montant),0)) as total from paiements p,depenses d WHERE p.depense_id = depenses.id))=0");
            }
            else if($payer == 1)
            {
                //Solde total
                $queryTotal = $queryTotal->whereRaw("(select ROUND(COALESCE(SUM(d.montant),0)) as total from depenses d WHERE d.id=depenses.id)<=(select ROUND(COALESCE(SUM(p.montant),0)) as total from paiements p WHERE p.depense_id = depenses.id)");
            }
            else if($payer == 2)
            {
                //Solde partiel
                $queryTotal = $queryTotal->whereRaw("((select ROUND(COALESCE(SUM(p.montant),0)) as total from paiements p,depenses d WHERE p.depense_id = depenses.id))!=0");
                $queryTotal = $queryTotal->whereRaw("(select ROUND(COALESCE(SUM(d.montant),0)) as total from depenses d WHERE d.id=depenses.id)>(select ROUND(COALESCE(SUM(p.montant),0)) as total from paiements p WHERE p.depense_id = depenses.id)");
            }
        }

        $sesCaisses = Outil::donneAllCaissesUser();
        if(Outil::voirDepenseTrancheHoraireEnCours() == 1)
        {
            //Pour les caissiers en général ==> ne voir que les dépenses de leur tranche horaire et de leurs caisse affectées
            $trancheHoraireEnCours = Outil::donneTrancheHoraire();
            if(isset($trancheHoraireEnCours))
            {
                $queryTotal = $queryTotal->whereIn('depenses.caisse_id', $sesCaisses);

                $dateToday = date('Y-m-d');
                $heureStart = substr($trancheHoraireEnCours->heure_debut, 11, 5);
                $heureEnd = substr($trancheHoraireEnCours->heure_fin, 11, 5);
                $dateStart = $dateToday." ".$heureStart.":00";
                $dateEnd = $dateToday." ".$heureEnd.":00";

               // $queryTotal = $queryTotal->whereBetween('date', array($dateStart, $dateEnd));
            }
            else
            {
                //Ne voir aucune dépense
               // $queryTotal = $queryTotal->where('id', 0);

                //$queryTotal = $queryTotal->id('id', 0);
            }
        }
        else
        {
            $queryTotal = $queryTotal->where(function ($queryTotal) use ($sesCaisses) {
                return $queryTotal->where('depenses.created_at_user_id', Outil::donneUserId())
                    ->orWhereIn('depenses.caisse_id', $sesCaisses);
            });
        }

        if(!self::isAuthorize())
        {
            //***[Barrane = NO] ==> [compta = 0]***//
            $queryTotal = $queryTotal->where('depenses.compta', 0);
        }
        else if(Outil::isAuthorize() == 1 && !isset($compta))
        {
            $queryTotal = $queryTotal->where('depenses.compta', '<=', 1);
        }
        else
        {
            //***[Barrane = YES] ==> Aurorisé à filtrer**//
            if (isset($compta))
            {
                $queryTotal = $queryTotal->where('depenses.compta', $compta);
            }
        }

        $queryTotal = $queryTotal->selectRaw('paiements.*')->get();
        //$retour = $queryTotal->total;

        //dd($queryTotal,);
        return $queryTotal;
    }


    public function resume_commande($itemArray){

            $date_debut             = $itemArray["date_debut"];
            $date_fin               = $itemArray["date_fin"];

            $diffJours = Outil::nombreJoursEntreDeuxDates($date_debut, $date_fin);

            $donneesJour = array();
            $donneesCouvert = array();
            $donneesCaNonOffert = array();
            $donneesCaOffert = array();
            $donneesCaTotal = array();
            $donneesLivraison = array();
            $donneesEmporte = array();
            $donneesEncCash = array();
            $donneesEncBanque = array();
            $donneesEncaissement = array();
            $donneesManquant = array();
            $donneesBilletage = array();
            for($i = 0; $i <= $diffJours; $i++)
            {
                $dateRequete = Outil::donneDateParRapportNombreJour($date_debut, $i);
                $dateRequeteDebut = $dateRequete." 00:00";
                $dateRequeteFin = $dateRequete." 23:59";

                $datedateRequeteFr = Outil::dateEnFrancais($dateRequete);
                $totalCa = 0;

                //Jours
                array_push($donneesJour,  array(
                    "date"                  => $dateRequete,
                    "date_fr"               => $datedateRequeteFr,
                ));

                //Nombre de couverts
                $query = DB::table('commandes')
                    ->whereBetween('commandes.date', [$dateRequeteDebut, $dateRequeteFin]);
                $query = Outil::rajouteElements($query, $itemArray);
                $query = $query->selectRaw('COALESCE(SUM(commandes.nombre_couvert),0) as total');
                $query = $query->first()->total;
                array_push($donneesCouvert,  array(
                    "date"                  => $dateRequete,
                    "date_fr"               => $datedateRequeteFr,
                    "total"                 => $query,
                ));

                //CA non offerts
                $query = DB::table('commande_produits')
                    ->join('commandes', 'commandes.id', '=', 'commande_produits.commande_id')
                    ->where('commande_produits.offre', false)
                    ->whereBetween('commandes.date', [$dateRequeteDebut, $dateRequeteFin]);
                $query = Outil::rajouteElements($query, $itemArray, 'commande_produits');
                $query = $query->selectRaw('COALESCE(SUM(commande_produits.montant),0) as total');
                $query = $query->first()->total;
                $totalCa += $query;
                array_push($donneesCaNonOffert,  array(
                    "date"                  => $dateRequete,
                    "date_fr"               => $datedateRequeteFr,
                    "total"                 => $query,
                ));

                //CA offerts
                $query = DB::table('commande_produits')
                    ->join('commandes', 'commandes.id', '=', 'commande_produits.commande_id')
                    ->where('commande_produits.offre', true)
                    ->whereBetween('commandes.date', [$dateRequeteDebut, $dateRequeteFin]);
                $query = Outil::rajouteElements($query, $itemArray, 'commande_produits');
                $query = $query->selectRaw('COALESCE(SUM(commande_produits.montant),0) as total');
                $query = $query->first()->total;
                $totalCa += $query;
                array_push($donneesCaOffert,  array(
                    "date"                  => $dateRequete,
                    "date_fr"               => $datedateRequeteFr,
                    "total"                 => $query,
                ));

                //CA total
                array_push($donneesCaTotal,  array(
                    "date"                  => $dateRequete,
                    "date_fr"               => $datedateRequeteFr,
                    "total"                 => $totalCa,
                ));

                //Nbre commande à livrer
                $typecommande = Typecommande::where('designation','à livrer')->first();
                if(isset($typecommande))
                {
                    $query = DB::table('commandes')
                        ->where('commandes.type_commande_id', $typecommande->id)
                        ->whereBetween('commandes.date', [$dateRequeteDebut, $dateRequeteFin]);
                    $query = Outil::rajouteElements($query, $itemArray);
                    $query = $query->count();
                    array_push($donneesLivraison,  array(
                        "date"                  => $dateRequete,
                        "date_fr"               => $datedateRequeteFr,
                        "total"                 => $query,
                    ));
                }

                //Nbre commande à emporter
                $typecommande = Typecommande::where('designation','à emporter')->first();
                if(isset($typecommande))
                {
                    $query = DB::table('commandes')
                        ->where('commandes.type_commande_id', $typecommande->id)
                        ->whereBetween('commandes.date', [$dateRequeteDebut, $dateRequeteFin]);
                    $query = Outil::rajouteElements($query, $itemArray);
                    $query = $query->count();
                    array_push($donneesEmporte,  array(
                        "date"                  => $dateRequete,
                        "date_fr"               => $datedateRequeteFr,
                        "total"                 => $query,
                    ));
                }

                //Total encaissement cash
                $modepaiements = Modepaiement::where('paiement_cash',1)->get();
                $modePaiementsArray = array();
                $totalEncCash = 0;
                foreach ($modepaiements as $value)
                {
                    $query = DB::table('encaissements')
                        ->join('cloture_caisses', 'cloture_caisses.id', '=', 'encaissements.cloture_caisse_id')
                        ->where('cloture_caisses.type', 0)
                        ->where('encaissements.mode_paiement_id', $value->id)
                        ->whereBetween('cloture_caisses.created_at', [$dateRequeteDebut, $dateRequeteFin]);
                    $query = Outil::rajouteElements($query, $itemArray, 'encaissements');
                    $query = $query->selectRaw('COALESCE(SUM(encaissements.montant),0) as total');
                    $query = $query->first()->total;
                    $totalEncCash += $query;
                }
                array_push($donneesEncCash,  array(
                    "date"                  => $dateRequete,
                    "date_fr"               => $datedateRequeteFr,
                    "total"                 => $totalEncCash,
                ));

                //Total encaissement banque
                $modepaiements = Modepaiement::where('banque',1)->get();
                $modePaiementsArray = array();
                $totalEncBanque = 0;
                foreach ($modepaiements as $value)
                {
                    $query = DB::table('encaissements')
                        ->join('cloture_caisses', 'cloture_caisses.id', '=', 'encaissements.cloture_caisse_id')
                        ->where('cloture_caisses.type', 0)
                        ->where('encaissements.mode_paiement_id', $value->id)
                        ->whereBetween('cloture_caisses.created_at', [$dateRequeteDebut, $dateRequeteFin]);
                    $query = Outil::rajouteElements($query, $itemArray, 'encaissements');
                    $query = $query->selectRaw('COALESCE(SUM(encaissements.montant),0) as total');
                    $query = $query->first()->total;
                    $totalEncBanque += $query;
                }
                array_push($donneesEncBanque,  array(
                    "date"                  => $dateRequete,
                    "date_fr"               => $datedateRequeteFr,
                    "total"                 => $totalEncBanque,
                ));

                //Encaissements clotures caisse
                $modepaiements = Modepaiement::all();
                $modePaiementsArray = array();
                foreach ($modepaiements as $value)
                {
                    $query = DB::table('encaissements')
                        ->join('cloture_caisses', 'cloture_caisses.id', '=', 'encaissements.cloture_caisse_id')
                        ->where('cloture_caisses.type', 0)
                        ->where('encaissements.mode_paiement_id', $value->id)
                        ->whereBetween('cloture_caisses.created_at', [$dateRequeteDebut, $dateRequeteFin]);
                    $query = Outil::rajouteElements($query, $itemArray, 'encaissements');
                    $query = $query->selectRaw('COALESCE(SUM(encaissements.montant),0) as total');
                    $query = $query->first()->total;
                    array_push($modePaiementsArray,  array(
                        "date"                  => $dateRequete,
                        "date_fr"               => $datedateRequeteFr,
                        "modepaiement"          => $value->designation,
                        "total"                 => $query,
                    ));
                }
                array_push($donneesEncaissement,  array(
                    "date"                  => $dateRequete,
                    "date_fr"               => $datedateRequeteFr,
                    "modepaiements"         => $modePaiementsArray,
                ));

                //Manquant
                $query = DB::table('cloture_caisses')
                    ->where('cloture_caisses.type', 0)
                    ->whereBetween('cloture_caisses.created_at', [$dateRequeteDebut, $dateRequeteFin]);
                $query = Outil::rajouteElements($query, $itemArray, 'encaissements');
                $query = $query->selectRaw('COALESCE(SUM(cloture_caisses.montant_manquant),0) as total');
                $query = $query->first()->total;
                array_push($donneesManquant,  array(
                    "date"                  => $dateRequete,
                    "date_fr"               => $datedateRequeteFr,
                    "total"                 => $query,
                ));

            }

            //Billetages
            $dateGlobalDebut = $date_debut." 00:00";
            $dateGlobalFin = $date_fin." 23:59";
            $typebillets = Typebillet::all();
            $totalBilletage = 0;

            foreach ($typebillets as $value)
            {
                $query = DB::table('billetages')
                    ->join('cloture_caisses', 'cloture_caisses.id', '=', 'billetages.cloture_caisse_id')
                    ->where('cloture_caisses.type', 0)
                    ->where('billetages.type_billet_id', $value->id)
                    ->whereBetween('cloture_caisses.created_at', [$dateGlobalDebut, $dateGlobalFin]);

                $query = Outil::rajouteElements($query, $itemArray, 'encaissements');

                $query = $query->selectRaw('COALESCE(SUM(cloture_caisse_type_billets.nombre),0) as nombre');

                $query = $query->first()->nombre;
//                    dd($dateGlobalFin);
                $total = $query * $value->nombre;

                $totalBilletage += $total;
                array_push($donneesBilletage,  array(
                    "typebillet"            => $value->designation,
                    "nombre"                => $query,
                    "total"                 => $total,
                ));

            }

            $retour = array(
                'jours'                     => $donneesJour,
                'nbre_couvert'              => $donneesCouvert,
                'ca_total_non_offert'       => $donneesCaNonOffert,
                'ca_total_offert'           => $donneesCaOffert,
                'ca_total'                  => $donneesCaTotal,
                'nbre_livraison'            => $donneesLivraison,
                'nbre_a_emporter'           => $donneesEmporte,
                'total_cash'                => $donneesEncCash,
                'total_banque'              => $donneesEncBanque,
                'encaissements'             => $donneesEncaissement,
                'manquant'                  => $donneesManquant,
                'billetages'                => $donneesBilletage,
                'total_billetage'           => $totalBilletage,
            );

    }


    // public static function sendEmail($classe, $pdf )
    // {
    //     $email = Preference::emailrapport()->valeur ?? 'waelsharara@fourchettedakar.com';
    //     Mail::to($email)->send( new $classe($pdf));
    // }
    public static function envoiEmailSimple($destinataire, $sujet, $texte, $pdfPath)
    {
        Mail::to($destinataire)
            ->send(new Maileur($sujet, $texte, $pdfPath));
        return true;
    }
    // public static function envoiEmail($destinataire, $sujet, $texte, $page = 'maileur', $cc = null)
    // {
    //     $texte = str_replace("\n", '<br>', $texte);
    //     $texte = new HtmlString($texte);
    //     if (isset($cc)) {
    //         Mail::to($destinataire)
    //             ->cc($cc)
    //             ->send(new Maileur($sujet, $texte, $page));
    //         return true;
    //     } else {
    //         Mail::to($destinataire)
    //             ->send(new Maileur($sujet, $texte, $page));
    //         return true;
    //     }
    // }
}
