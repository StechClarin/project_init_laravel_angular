<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mpdf\Tag\U;
use App\Models\{
    ClientTypeDossier,
    Outil,
    Contact,
    ClientMarchandise,
    TypeClient,
    TypeDossier,
    User,
    ValidationDossier
};
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;

class ClientController extends EntityTypeController
{
    protected function getValidationRules(): array
    {
        return [
            'nom' => [
                'required',
                Rule::unique($this->table)->where('nom', $this->request->nom)->ignore($this->modelId)
            ],

            'type_client_id' => 'required',

            'telephone' => [
                'required',
                Rule::unique($this->table)->where('telephone', $this->request->telephone)->ignore($this->modelId)
            ],
        ];
    }
    protected function getCustomValidationMessage(): array
    {
        return [
            'type_client_id.required' => "Renseigner le type de client",
            'telephone.unique' => "numero déja utilisé"
        ];
    }
    public function beforeValidateData(): void
    {
        if (!isset($this->request->id)) {
            $this->request['code'] = Outil::getCode($this->model, $this->modelValue->codePrefix);
        }

        // dd($this->request->all());

        if ($this->request->from_excel) {
            $getTypeClient = TypeClient::query()->whereRaw('TRIM(unaccent(lower(nom))) = TRIM(unaccent(lower(?)))', [$this->request["type_client_id"]])->first();
            $this->request["type_client_id"] = $getTypeClient->id ?? null;
            // dd($this->request);

            // dd($this->request["type_client_id"]);
            $res = [];
        }

    }





    public function afterCRUDProcessing(&$model): void
    {
        // dd($this->request->details);
        $data = parseArray($this->request->details, Contact::class);
        $model->saveHasManyRelation($data, Contact::class);
        // dd($data, $model);

        //Check old users and compare with news for function checkDetail
        $users = parseArray($this->request->users, ['id', 'name', 'email', 'telephone', 'password', 'imageName', 'eraseName']);
        $allusers = User::where('client_id', $this->modelId)->get();

        //USERS
        if (isset($allusers)) {
            Outil::Checkdetail($allusers, $users, User::class, ['id']);
        }

        //Utilisateur Client
        //dd($users);
        $files = $this->request->file();
        $role = Role::query()->where('name', Outil::getOperateurLikeDB(), '%client%')->first();
        if (isset($role)) {
            foreach ($users as $key => $value) {
                $errors = null;
                $userToSave = null;
                $line = $key + 1;
                if (empty($value["name"])) {
                    $errors = "Ids connexion ==> Le nom est obligatoire à la ligne {$line}";
                }
                if (empty($value["email"])) {
                    $errors = "Ids connexion ==> L'email est obligatoire à la ligne {$line}";
                }
                if (empty($value["password"]) && empty($value['id'])) {
                    $errors = "Ids connexion ==> Le mot de passe est obligatoire à la ligne {$line}";
                }

                $isEmailExist = User::query()->whereRaw('TRIM(lower(email)) = TRIM(lower(?))', [$value['email']])->count() > 0;

                if ($isEmailExist && empty($value['id'])) {
                    $errors = "Ids connexion ==> Un utilisateur avec ce même email existe déja ligne {$line}";
                }

                if (isset($errors)) {
                    throw new \Exception($errors);
                }
                if (!empty($value['id'])) {
                    $userToSave = User::query()->find($value['id']);
                }
                if (!isset($userToSave)) {
                    $userToSave = new User();
                }
                $userToSave->name = $value['name'];
                $userToSave->email = $value['email'];
                $userToSave->password = $value['password'] ?? null;
                $userToSave->client_id = $this->modelValue->id;

                $userToSave->save();

                $userToSave->syncRoles([$role->id]);

                $subRequest = new Request();

                if (isset($value["eraseName"])) {
                    $subRequest[$value['eraseName']] = $this->request[$value['eraseName']];
                }

                if (isset($value["imageName"])) {
                    foreach ($files as $skey => $svalue) {
                        if ($skey === $value['imageName']) {
                            $subRequest->files->set('file', $svalue);
                        }
                    }

                    Outil::uploadFileToModel($subRequest, $userToSave, $value["imageName"]);
                }
            }
        }

    }
}
