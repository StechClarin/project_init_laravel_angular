<?php

namespace App\Http\Controllers;

use App\Models\BilanPointage;
use App\RefactoringItems\CRUDController;
use Illuminate\Validation\Rule;
use App\Models\DetailsPointage;
use Carbon\Carbon;

class PointageController extends CRUDController
{
    protected function getValidationRules(): array
    {
        return [
            'personnel_id' => ['required'],
            'date_debut' => ['required'],
            'date_fin' => ['required'],
        ];
    }

    protected function getCustomValidationMessage(): array
    {
        return [
            'personnel_id' => "veillez selectionner un membre personnel",
            'date_debut' => 'veillez renseigner une date de début',
            'date_fin' => 'veillez renseigner une date de fin',
        ];
    }

    public function beforeValidateData(): void
    {
        if (!$this->request->filled('temps_au_bureau')) {
            $this->request->merge(['temps_au_bureau' => 0]);
        }
        $this->request['details'] = json_decode($this->request->details);

        if ($this->request->date_debut) {
            $dateDebut = Carbon::createFromFormat('d/m/Y', $this->request->date_debut);

            $this->request->merge(['date_debut' => $dateDebut->format('Y-m-d')]);
        }

        if ($this->request->date_fin) {
            $dateFin = Carbon::createFromFormat('d/m/Y', $this->request->date_fin);
            // if ($dateFin->lt(today())) {
            //     throw new \Exception('La date de fin ne peut être une date passée.');
            // }
            $this->request->merge(['date_fin' => $dateFin->format('Y-m-d')]);
        }

        $personnel_id = $this->request->personnel_id;

        foreach ($this->request['details'] as $detail) {
            $detail->personnel_id = $personnel_id;

            // // Convertir day => date
            // if (!empty($detail->day)) {
            //     try {
            //         $detail->date = $this->convertJsDateToYmd($detail->day);
            //     } catch (\Exception $e) {
            //         throw new \Exception("Erreur de conversion de date dans un des détails : " . $e->getMessage());
            //     }
            // }
            if (empty($detail->heure_depart)) {
                $detail->heure_depart = '00:00:00';
            }
            if ($detail->absence) {
                $detail->heure_arrive = null;
                $detail->heure_depart = null;
            }
        }
    }

    public function afterCRUDProcessing(&$model): void
    {
        $detailpointage = new DetailsPointage();
        $personnel_id = $model->personnel_id;
        $detailpointage->personnel_id = $personnel_id;
        // dd($detailpointage->date);
        $data = $this->request->details;
        // dd($data);
        $model->saveHasManyRelation($data, DetailsPointage::class);
    }


    private function convertJsDateToYmd(string $dayString): string
    {
        preg_match('/\w{3} (\w{3}) (\d{1,2}) (\d{4})/', $dayString, $matches);

        if (count($matches) !== 4) {
            throw new \Exception("Format de date invalide dans l'un des détails : $dayString");
        }

        [$_, $monthStr, $day, $year] = $matches;

        $months = [
            'Jan' => '01',
            'Feb' => '02',
            'Mar' => '03',
            'Apr' => '04',
            'May' => '05',
            'Jun' => '06',
            'Jul' => '07',
            'Aug' => '08',
            'Sep' => '09',
            'Oct' => '10',
            'Nov' => '11',
            'Dec' => '12',
        ];

        if (!isset($months[$monthStr])) {
            throw new \Exception("Mois invalide : $monthStr");
        }

        return sprintf('%s-%s-%02d', $year, $months[$monthStr], $day);
    }
}
