<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Tache;
use App\Models\Personnel;
use App\Models\BilanTache;
use App\RefactoringItems\CRUDController;
use Exception;

use function PHPUnit\Framework\isNull;

class TacheAssigneController extends CRUDController
{
    protected function getValidationRules(): array
    {
        return [
            'projet_id' => [
                'required',
            ]
        ];
    }


    protected function getCustomValidationMessage(): array
    {
        return [
            'projet_id.required'  => "Veillez selectionner un projet",
        ];
    }

    public function beforeValidateData(): void
    {
        if (empty($this->request->personnel_id)) {
            $user = auth()->user();

            if (!$user || !$user->email) {
                throw new \Exception("Utilisateur non authentifié ou email non disponible.");
            }

            $personnel = Personnel::where('email', $user->email)->first();

            if (!$personnel) {
                throw new \Exception("L'utilisateur connecté n'est pas membre du personnel.");
            }

            // On injecte l’id du personnel dans la requête
            $this->request->merge(['personnel_id' => $personnel->id]);
        }
    }


    public function afterStatut($model): void
    {
        $status = (int) $this->request->status;
        dd($status); 
        if ($status === 1) {
            $model->status = 1;
            $model->date_debut = now();
            $model->date_fin = null;
            $model->duree = null;
            $model->save();
        } elseif ($status === 2) {
            $model->status = 2;
            $model->date_fin = now();

            $dateDebut = $model->date_debut ? \Carbon\Carbon::parse($model->date_debut) : null;
            $dateFin = $model->date_fin ? \Carbon\Carbon::parse($model->date_fin) : null;

            if ($dateDebut && $dateFin) {
                $minutes = $dateDebut->diffInMinutes($dateFin);
                $hours = floor($minutes / 60);
                $mins = $minutes % 60;
                $model->duree = sprintf('%02d:%02d', $hours, $mins);
            } else {
                $model->duree = null;
            }
            $model->save();
        }
    }

    public function afterCRUD(&$model): void
    {
        $bilantache = new BilanTache();
        $bilantache->personnel_id = $model->personnel_id;
        $bilantache->tacheassigne_id = $model->id;
        $bilantache->date = now()->format('Y-m-d');
        $bilantache->save();
    }
}
