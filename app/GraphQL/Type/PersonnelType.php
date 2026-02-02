<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Carbon\Carbon;
use App\Models\{User};



class PersonnelType extends RefactGraphQLType
{
    protected function resolveFields(): array
    {

        return [
            'id'                                 => ['type' => Type::int()],
            'anciennete'                         => ['type' => Type::int()],
            'nom'                                => ['type' => Type::string()],
            'nomcp'                              => ['type' => Type::string()],
            'display_text'                       => ['type' => Type::string(), 'alias' => 'nom'],
            'prenom'                             => ['type' => Type::string()],
            'date_naissance'                     => ['type' => Type::string()],
            'lieu_naissance'                     => ['type' => Type::string()],
            'telephone'                          => ['type' => Type::int()],
            'telephonecp'                        => ['type' => Type::int()],
            'email'                              => ['type' => Type::string()],
            'emailcp'                            => ['type' => Type::string()],
            'adresse'                            => ['type' => Type::string()],
            'date_embauche'                      => ['type' => Type::string()],
            'fonction'                           => ['type' => Type::string()],
            'password'                           => ['type' => Type::string()],
            'connectivite'                       => ['type' => Type::boolean()],
            'role_id'                            => ['type' => Type::int()],
            'role'                              => ['type' =>  GraphQL::type('RoleType')],
            'user'                              => ['type' =>  GraphQL::type('UserType')],
            'pointages'                          => ['type' => Type::listOf(GraphQL::type('PointageType'))],
            'planificationassignes'              => ['type' => Type::listOf(GraphQL::type('PlanificationAssigneType'))],
            'tacheprojets'                       => ['type' => Type::listOf(GraphQL::type('TacheProjetType'))],
        ];
    }

    protected function resolveAncienneteField($root, $args)
    {
        if (!isset($root['date_embauche'])) {
            return null;
        }

        return Carbon::parse($root['date_embauche'])->diffInYears(Carbon::now());
    }

    protected function resolveDisplayTextField($root, $args)
    {
        return $root['nom'] . ' ' . $root['prenom'];
    }

    protected function resolveUserField($root, $args)
    {
        try {
            $user = User::where('email', $root->email)->first();
            
            if (!$user) {
                return $this->getDefaultImage();
            }
    
            if (empty($user->image)) {
                return $this->getDefaultImage();
            }
    
            if (filter_var($user->image, FILTER_VALIDATE_URL)) {
                return $user->image;
            }
    
            $imagePath = storage_path('app/public/' . ltrim($user->image, '/'));
            
            if (file_exists($imagePath)) {
                return asset('storage/' . ltrim($user->image, '/'));
            }
    
            return $this->getDefaultImage();
        } catch (\Exception $e) {
            return $this->getDefaultImage();
        }
    }
    
    protected function getDefaultImage()
    {
        // Chemin vers votre image par défaut (peut être une URL ou un chemin local)
        return "assets/media/logos/logo.svg";
        
        // Ou une image générique type Gravatar
        // $emailHash = md5(strtolower(trim($root->email ?? '')));
        // return "https://www.gravatar.com/avatar/{$emailHash}?d=identicon";
    }
}
