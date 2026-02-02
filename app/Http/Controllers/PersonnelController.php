<?php

namespace App\Http\Controllers;


use Spatie\Permission\Models\Role;
use App\RefactoringItems\CRUDController;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Contact;
use App\Models\Personnel;
use Illuminate\Support\Facades\Hash;

class PersonnelController extends CRUDController
{


    protected function getValidationRules(): array
    {
        return [
            'nom' => ['required'],
            'telephone' => [
                'required',
                Rule::unique($this->table)->where('telephone', $this->request->telephone)->ignore($this->modelId)
            ],
            'password'              => Rule::requiredIf(function () {
                return is_null($this->modelId);
            }),
            'email' => [
                'required',
                Rule::unique($this->table)->where('email', $this->request->email)->ignore($this->modelId)
            ],
            'date_naissance' => 'required',
            'date_embauche' => 'required',
            'prenom' => 'required',
            'nomcp' => 'required',
            'telephonecp' => 'required',
            'adresse' => 'required',
            'role_id' => 'required',
        ];
    }

    protected function getCustomValidationMessage(): array
    {
        return [
            'nom' => "Renseigner le nom du contact",
            'telephonecp' => "Renseigner le numéro de téléphone du contact d'urgence",
            'nom.required' => "Renseigner le nom",
            'telephone.unique' => "numero déja utilisé",
            'email.unique' => "email déja utilisé",
            'telephonecp.required' => 'Le numéro de téléphone du contact d\'urgence est obligatoire.',
            'telephone.unique' => 'Le numéro de téléphone doit être unique.',
            'aderesse.required' => 'veillez renseigner l\'adresse du personnel',
            'nomcp.required' => 'Le nom du contact d\'urgence est obligatoire.',
            'role_id.required' => 'Le profil est obligatoire.',
        ];
    }

    public function beforeValidateData(): void
    {
        if ($this->request->from_excel) {
            $connectivite = strtolower(trim($this->request["connectivite"] ?? ''));
            $this->request["connectivite"] = ($connectivite === 'oui');

            if (!$this->request["connectivite"]) {
                unset($this->request["role_id"], $this->request["password"]);
            } else {
                $role = Role::query()
                    ->whereRaw('TRIM(unaccent(lower(name))) = TRIM(unaccent(lower(?)))', [$this->request["role_id"]])
                    ->first();

                $this->request["role_id"] = $role->id ?? null;
            }
        }
    }

public function afterCRUDProcessing(&$model): void
{
    $connectivite = filter_var($this->request->connectivite, FILTER_VALIDATE_BOOLEAN);

    if ($connectivite) {
        $user = User::where('email', $model->email)->first();

        // ⚠ Si le personnel est déjà utilisateur (update)
        if ($user) {
            // Vérifier si un mot de passe est fourni (facultatif en update)
            if (!empty($this->request->password)) {
                if ($this->request->password !== $this->request->password_confirm) {
                    throw new \Exception("Les mots de passe ne correspondent pas !");
                }
                $user->password = Hash::make($this->request->password);
            }

            // Mettre à jour les infos du user
            $user->update([
                'name'      => $model->nom . ' ' . $model->prenom,
                'telephone' => $model->telephone,
            ]);

        } else {
            // ⚠ Cas création d'utilisateur → mot de passe obligatoire
            if (empty($this->request->password)) {
                throw new \Exception("Le mot de passe est obligatoire pour les nouveaux utilisateurs connectés.");
            }

            if ($this->request->password !== $this->request->password_confirm) {
                throw new \Exception("Les mots de passe ne correspondent pas !");
            }

            $user = User::create([
                'email'     => $model->email,
                'name'      => $model->nom . ' ' . $model->prenom,
                'telephone' => $model->telephone,
                'password'  => Hash::make($this->request->password),
            ]);
        }

        // Gérer les rôles
        if (!empty($this->request->role_id)) {
            $role = Role::find($this->request->role_id);
            if ($role) {
                $user->syncRoles([$role->name]);
            }
        }
    }
}

}
