<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Tache;
use App\Models\Personnel;
use App\Models\BilanTache;
use App\RefactoringItems\CRUDController;
use Exception;
use Carbon\Carbon;


use function PHPUnit\Framework\isNull;

class TacheProjetController extends CRUDController
{
    protected function getValidationRules(): array
    {
        return [
            'projet_id' => [
                'required',
            ],
            'priorite_id' => [
                'required',
            ],
            'nom_tache' => [
                'required',
                Rule::unique($this->table)->ignore($this->modelId)

            ],
            'duree' => [
                'required',
            ],
        ];
    }


    protected function getCustomValidationMessage(): array
    {
        return [
            'projet_id.required'  => "Veillez selectionner un projet",
            "priorite_id.required" => "veillez indiquer la priorité de la tache",
            "nom_tache.required" => "veillez nommez la tache (le nom doit etre unique à la tache)",
            "duree.required" => "veillez indiquer la durée de la tache",
        ];
    }

    public function beforeValidateData(): void
    {

        if (!$this->request->has("date")) {
            $this->request->merge(['date' => now()->format('Y-m-d')]);
        }

        if ($this->request->duree) {
            $minutes = intval($this->request->duree);
            $heures = floor($minutes / 60);
            $restantMinutes = $minutes % 60;
            $dureeFormatee = sprintf('%02d:%02d:00', $heures, $restantMinutes);

            $this->request->merge(['duree' => $dureeFormatee]);
        }

        if ($this->request->date_debut) {
            $dateDebut = Carbon::createFromFormat('d/m/Y', $this->request->date_debut);
            // dd($dateDebut);
            if ($dateDebut->lt(today())) {
                throw new \Exception('La date de début ne peut être une date passée.');
            }
            $this->request->merge(['date_debut' => $dateDebut->format('Y-m-d')]);
        }

        if ($this->request->date_fin) {
            $dateFin = Carbon::createFromFormat('d/m/Y', $this->request->date_fin);
            if ($dateFin->lt(today())) {
                throw new \Exception('La date de fin ne peut être une date passée.');
            }
            $this->request->merge(['date_fin' => $dateFin->format('Y-m-d')]);
        }
        if (empty($this->request->personnel_id)) {
            $user = auth()->user();

            if (!$user || !$user->email) {
                throw new \Exception("Utilisateur non authentifié ou email non disponible.");
            }

            $personnel = Personnel::where('email', $user->email)->first();

            if (!$personnel) {
                throw new \Exception("L'utilisateur connecté n'est pas membre du personnel! veillez selection un membre du personnel");
            }

            // On injecte l’id du personnel dans la requête
            $this->request->merge(['personnel_id' => $personnel->id]);
        }
    }

    private function getEffectiveWorkDuration(Carbon $start, Carbon $end): int
    {
        $workStartNormal = '08:30:00';
        $workEndNormal = '17:00:00';
        $workStartSaturday = '09:00:00';
        $workEndSaturday = '14:00:00';

        $totalMinutes = 0;

        $current = $start->copy();

        while ($current->lt($end)) {
            // Ignorer les dimanches
            if ($current->dayOfWeek === Carbon::SUNDAY) {
                $current->addDay();
                continue;
            }

            $workStartTime = $current->copy();
            $workEndTime = $current->copy();

            if ($current->dayOfWeek === Carbon::SATURDAY) {
                $workStartTime->setTimeFromTimeString($workStartSaturday);
                $workEndTime->setTimeFromTimeString($workEndSaturday);
            } else {
                $workStartTime->setTimeFromTimeString($workStartNormal);
                $workEndTime->setTimeFromTimeString($workEndNormal);
            }

            $intervalStart = $start->gt($workStartTime) ? $start : $workStartTime;
            $intervalEnd = $end->lt($workEndTime) ? $end : $workEndTime;

            if ($intervalStart->lt($intervalEnd)) {
                $totalMinutes += $intervalStart->diffInMinutes($intervalEnd);
            }

            $current->addDay();
        }

        return $totalMinutes;
    }




    public function afterStatut($model): void
    {
        $status = (int) $this->request->status;
        // dd($status); 
        if ($status === 1) {
            $model->status = 1;
            $model->date_debut2 = now();
            $model->date_fin2 = null;
            $model->duree_effectue = null;
            $model->save();
        } elseif ($status === 2) {
            $model->status = 2;
            $model->date_fin2 = now();

            $dateDebut = $model->date_debut2 ? Carbon::parse($model->date_debut2) : null;
            $dateFin = $model->date_fin2 ? Carbon::parse($model->date_fin2) : null;

            if ($dateDebut && $dateFin) {
                $minutes = $this->getEffectiveWorkDuration($dateDebut, $dateFin);
                $hours = floor($minutes / 60);
                $mins = $minutes % 60;
                $model->duree_effectue = sprintf('%02d:%02d', $hours, $mins);
            } else {
                $model->duree_effectue = null;
            }

            $model->save();
        }
    }

    public function afterCRUD(&$model): void
    {
        $model->date = now();
        $model->save();
    }
}
