<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use App\Models\{ModuleDepartement,ProjetDepartement,ProjetModule,FonctionnaliteModule,TacheFonctionnalite};
class ProjetType extends RefactGraphQLType
{
    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'code'                               => ['type' => Type::string()],
            'nom'                                => ['type' => Type::string()],
            'description'                        => ['type' => Type::string()],
            'date_debut'                         => ['type' => Type::string()],
            'date_fin'                         => ['type' => Type::string()],
            'date_cloture'                       => ['type' => Type::string()],
            'date_prochain_renouvellement'       => ['type' => Type::string()],
            'hebergeur'                          => ['type' => Type::string()],
            'serveur'                            => ['type' => Type::string()],
            'tarif'                              => ['type' => Type::int()],
            'progression'                        => ['type' => Type::int()],
            'lien_test'                          => ['type' => Type::string()],
            'identifiant_test'                   => ['type' => Type::string()],
            'mot_de_passe_test'                  => ['type' => Type::string()],
            'lien_prod'                          => ['type' => Type::string()],
            'identifiant_prod'                   => ['type' => Type::string()],
            'mot_de_passe_prod'                  => ['type' => Type::string()],
            'status'                             => ['type' => Type::int()],

            'display_text'                       => ['type' => Type::string(), 'alias' => 'nom'],
            'status_fr'                          => ['type' => Type::string()],
            'color_status'                       => ['type' => Type::string()],
            'date_debut_fr'                      => ['type' => Type::string()],
            'date_fin_fr'                      => ['type' => Type::string()],
            'date_cloture_fr'                    => ['type' => Type::string()],
            'date_prochain_renouvellement_fr'    => ['type' => Type::string()],

            'type_projet_id'                     => ['type' => Type::int()],
            'type_projet'                        => ['type' => GraphQL::type('TypeProjetType')],

            'client_id'                          => ['type' => Type::int()],
            'client'                             => ['type' => GraphQL::type('ClientType')],

            // Pour les clients uniquement
            'users'                               => ['type' => Type::listOf(GraphQL::type('UserType'))],
            'departements'                        => ['type' => Type::listOf(GraphQL::type('DepartementType'))],
            'nombre_tache'                       => ['type' => Type::int()],
            'nombre_tache_close'                 => ['type' => Type::int()],
            'noyauxinterne_id'                   => ['type' => Type::int()],
            'noyauxinterne'                      => ['type' => GraphQL::type('NoyauxInterneType')],

        ];
    }
    public function resolve($root, $args, $context)
    {
         $dep = $root->projet_departements->departements;
         return $dep;
    }

    public function resolveDateFinFrField($root, $args){
        //la date fin est la date de cloture
        if($root->date_cloture){
            $date = \DateTime::createFromFormat('Y-m-d', $root->date_cloture);
            if ($date) {
                return $date->format('d/m/Y');  
            }
        }
    }

    public function resolveProgressionField($root, $args)
    {
        $total = $this->resolveNombreTacheField($root, $args);
        if($total == 0) return 0;
        $close = $this->resolveNombreTacheCloseField($root, $args);
        $value = $close*100/$total;
        return (int)$value ?? 0;
    }
    public function resolveNombreTacheCloseField($root, $args)
    {
        $moduleId = ProjetModule::where('projet_id', $root->id)  
            ->pluck('id');
       
        $fonctionnaliteId = FonctionnaliteModule::whereIn('projet_module_id',$moduleId)->pluck('id');    
        
        $count = TacheFonctionnalite::where('status', 1)  
            ->whereIn('fonctionnalite_module_id', $fonctionnaliteId)    
            ->count();

        return $count; 
    }

    public function resolveNombreTacheField($root, $args)
    {
        $moduleId = ProjetModule::where('projet_id', $root->id)  
            ->pluck('id'); 

        $fonctionnaliteId = FonctionnaliteModule::whereIn('projet_module_id',$moduleId)->pluck('id'); 

        $count = TacheFonctionnalite::where('status','<>',null)  
            ->whereIn('fonctionnalite_module_id', $fonctionnaliteId)    
            ->count() ?? 0;
      
        return $count;  
    }

}
