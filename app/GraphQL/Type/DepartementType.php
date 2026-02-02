<?php

namespace App\GraphQL\Type;

use App\RefactoringItems\RefactGraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\{DB};
use App\Models\{ProjetDepartement,Projet,ProjetModule,FonctionnaliteModule,TacheFonctionnalite};

class DepartementType extends RefactGraphQLType
{
    protected function resolveFields(): array
    {
        return [
            'id'                                 => ['type' => Type::int()],
            'nom'                                => ['type' => Type::string()],
            'str_nom'                            => ['type' => Type::string()],
            'description'                        => ['type' => Type::string()],
            'image'                              => ['type' => Type::string()],
            'display_text'                       => ['type' => Type::string()],
            'modules'                            => ['type' => GraphQL::type('ProjetModuleType')],
            'projet_departements'                => ['type' => Type::listOf(GraphQL::type('ProjetDepartementType'))],
            'projet'                             => ['type' => Type::listOf(type::string())],
            'nombre_tache'                       => ['type' => Type::int()],
            'icon'                               => ['type' => Type::string()],
            'data'                               => ['type' => Type::listOf(Type::string())],
        ];
    }


    public function resolveStrNomField($root, $args)
    {
        
        return strtolower(str_replace(' ', '', $root->nom));  
    }
    public function resolveDataField($root, $args)
    {
        
        // Pour debug
        // dd($results);
        // $moduleId = ProjetModule::where('departement_id', $root->id)  
        //     ->pluck('id'); 

        // $fonctionnaliteId = FonctionnaliteModule::whereIn('projet_module_id',$moduleId)->pluck('fonctionnalite_id'); 

        // $count = TacheFonctionnalite::where('status','<>',null)  
        //     ->whereIn('fonctionnalite_id', $fonctionnaliteId)    
        //     ->count() ?? 0;

        return [];  
    }

    public function resolveIconField($root, $args)
    {
        return "assets/media/svg/icons/sidebar/icon-" . strtolower($root->nom) . ".svg";          
        
    }
    public function resolveNomProjetField($root, $args)
    {
        $idprojet = ProjetDepartement::where('departement_id',$root->id)->first()->projet_id;

        return Projet::where('id',$idprojet)->first()->nom;          
        
    }

}
