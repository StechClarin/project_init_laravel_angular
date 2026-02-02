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

class PlanificationAssigneController extends CRUDController
{








    public function afterStatut($model): void
    {
        $status = (int) $this->request->status;
        // dd($status); 
        if ($status === 1) {
            $model->status = 1;
            $model->date_debut = now();
            $model->date_fin = null;
            $model->duree_effectue = null;
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
                $model->duree_effectue = sprintf('%02d:%02d', $hours, $mins);
            } else {
                $model->duree_effectue = null;
            }
            $model->save();
        }
    }


}
