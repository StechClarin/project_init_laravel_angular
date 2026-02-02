<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Events\SendNotifEvent;
use App\Models\{
    Notif,
    NotifPermUser,
    Outil,
    User
};
use App\Mail\RapportProduction;

use Spatie\Permission\Models\Permission;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

   

    /**
     * @var array
     */
    private $array;

    /**
     * @var int
     */
    private $totals;

    /**
     * @var string
     */
    private $tagname;

    /**
     * @var string
     */
    private $TagTitle;
  

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($array, int $totals, $tagname, $TagTitle)
    {
        $this->array     = $array;
        $this->totals      = $totals;
        $this->tagname    = $tagname;
        $this->TagTitle  = $TagTitle;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function Notify($array,$totals,$tagname,$TagTitle)
    {
        Outil::setParametersExecution();

        $role = Role::where('name','super admin')->first();
        if(isset($role))
        {
            $users =User::where('role_id',$role->id)->get();
            foreach($users as $oneUser)
            {
                $this->SendRapport($oneUser->email,$array,$totals,$tagname,$TagTitle);

                $title = "Bonjour ".ucfirst($oneUser->name)." un rapport détaillé sur les prix de revient des produits qui ont changés au cours de {$TagTitle} vous est envoyé par mail";
                $notif = new Notif();
                $notif->message = $title;
                $notif->link = "#!/list-{$tagname}";
                $notif->icon  = null;
                $notif->save();

                $notifPermUser  = new NotifPermUser();
                $notifPermUser->notif_id = $notif->id;
                $notifPermUser->permission_id = Permission::where('name',"creation-{$tagname}" )->first()->id;
                $notifPermUser->user_id = $oneUser->id;
                $notifPermUser->save();

                $eventNotif = new SendNotifEvent($notifPermUser);
                event($eventNotif);
            }
        }
    }

    public function SendRapport($email,$array,$totals,$TagTitle)
    {
        $pdf = PDF::loadView("pdfs.new-rapport-production", array(
            'reports'       => $array,
            'title'         => "Rapport d'ajustement des prix de revient {$TagTitle}",
            'totals'        => [
                'toUpload'     => $totals,
                'upload'       => count($array),
            ],
            'addToData' => array('entete' => null, 'hidefooter' => true)
            ));
            Mail::to($email)->send(new RapportProduction($pdf));

    }
    public function handle()
    {
        $this->Notify($this->array,$this->totals,$this->tagname,$this->TagTitle);
    }
}
