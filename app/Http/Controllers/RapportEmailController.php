<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\{DB};
use App\Models\{Assistance, RapportAssistance, DetailRapport};
use Illuminate\Validation\Rule;
use App\Models\{Outil, RapportEmail};
use DateTime;

class RapportEmailController extends EntityTypeController
{
    protected function getValidationRules(): array
    {

        return [
            'destinataires' => ['required'],
            'objet'   => ['required'],
            'texte'   => ['required'],
            'files' => ['required'],
        ];
    }
    protected function getCustomValidationMessage(): array
    {
        return [
            'files.required'           => "Veuillez seectionner un ou plusieurs fichiers de format PDF",
            // 'files.*.required'      => "la taille minimum autoriser est 3Mo",
        ];
    }

    public function beforeValidateData(): void
    {
        $date = new \DateTime();
        $this->request->merge(['date' => $date->format('Y-m-d')]);

        $storedFile = null;

        $file = $this->request->file('files');
        if ($file && $file->isValid()) {
            $fileName = str_replace(' ', '_', time() . '_' . $file->getClientOriginalName());
            $path = $file->storeAs('uploads/email', $fileName, 'public');
            $storedFile = storage_path('app/public/' . $path);
        }

        foreach ((array) $this->request->destinataires as $destinataire) {
            if (Outil::envoiEmailSimple($destinataire, $this->request->objet, $this->request->texte, [$storedFile])) {
                $this->request->merge([
                    'destinataire' => $destinataire,
                    'file' => $storedFile
                ]);
            }
        }
    }
}
