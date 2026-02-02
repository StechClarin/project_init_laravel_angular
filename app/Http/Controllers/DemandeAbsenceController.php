<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mpdf\Tag\U;
use App\Models\{
    Outil,
    User,
    Personnel,
    ValidationDossier
};
use DateTime;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;


class DemandeAbsenceController extends EntityTypeController
{
    protected function getValidationRules(): array
    {
        return [

            'date_debut' => 'required',
            'date_fin' => 'required',
            'motif' => 'required',
            'description' => 'required',
            'employe_id' => 'required',
        ];
    }
    protected function getCustomValidationMessage(): array
    {
        return [
            'date_debut' => "Renseigner la Date de debut",
            'date_fin' => "Renseigner la Date de fin",
            'motif' => "Renseigner le motif",
            'description' => "Noter une description",
        ];
    }

    public function beforeValidateData():void
    {  

        $errors = null;
        $date = new DateTime(); 
        $this->request['date']= $date->format('Y-m-d');
        if (isset($this->request->date_debut) && $this->request->from_excel == false) {
            $date_debut = DateTime::createFromFormat('d/m/Y', $this->request->date_debut);
            if ($date_debut) {
                $this->request->merge(['date_debut' => $date_debut->format('Y-m-d')]);
            }
        }
        if (isset($this->request->date_fin) && $this->request->from_excel == false) {
            $date_fin = DateTime::createFromFormat('d/m/Y', $this->request->date_fin);
            if ($date_fin) {
                $this->request->merge(['date_fin' => $date_fin->format('Y-m-d')]);
            }
        }
        $future_date = date('Y-m-d', strtotime('+2 days')); 
        if(($this->request->date_debut > $this->request->date_fin) || $this->request->date_debut == $this->request->date_fin && !isset($this->request->heure_debut) && !isset($this->request->heure_fin)  ) 
        {
            $errors = "Vérifiez que la date de début de votre demande ne soit pas postérieure ou égale à la date de fin. !!";
        }
        else if ($this->request->date_debut < $future_date && empty($this->request->heure_debut) && empty($this->request->heure_fin) ) {  
            $errors = "Vérifiez que la demande soit 1 jours avant !";  
        } 

        // else if($this->request->heure_debut < $this->request->heure_fin && $this->request->date_debut !== $this->request->date_fin) 
        // {
        //     $errors = "Veuillez que l'heure soit conforme  !!";  
        // }

        if ($this->request->from_excel)
        {   
            if(isset($this->request['date_debut']))
            {
                $this->request['date_debut'] = $this->excelToDate($this->request->date_debut);
            }
            if(isset($this->request['date_fin']))
            {
                $this->request['date_fin'] = $this->excelToDate($this->request->date_fin);
            }

            if(isset($this->request["employe_id"]))
            {
                $getEmploye = Personnel::query()->whereRaw('TRIM(unaccent(lower(name))) = TRIM(unaccent(lower(?)))',[$this->request["employe_id"]])->first();
                if(isset($getEmploye->id))
                {
                    $this->request["employe_id"] = $getEmploye->id;
                }
                else
                {
                    $errors = $this->request["employe_id"]." N'existe pas dans le systeme";
                }
            }
            
            switch (strtolower($this->request["status"])) {
                case "en attente":
                    $this->request["status"] = 0;
                    break;
                case "non valide":
                    $this->request["status"] = 1;
                    break;
                case "valide":
                    $this->request["status"] = 2;
                    break;
                default:
                    $this->request["status"] = 0;
                    break;
            }
        }

        if(isset($errors))
        {
            throw new \Exception($errors);
        }
    }

    public function afterStatut($model): void
    {
        $messageEnCours = "Votre demande d'absence est en cours de traitement !";
        $messageRejetee = "Votre demande d'absence a été rejetée !";
        $messageValidee = "Votre demande d'absence a été validée !";
        $permission = "liste-demandeabsence";
    
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
    
      
    


    function excelToDate($excelDate) {
        $baseDate = new DateTime('1900-01-01');
        $baseDate->modify('+' . ($excelDate - 2) . ' days');
        return $baseDate->format('Y-m-d');
    }
}
