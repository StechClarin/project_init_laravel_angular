<?php

namespace Database\Seeders;

use App\Models\{Formulaire, ModeLink, Module};
use Illuminate\Database\Seeder;

class FormulaireSeeder extends Seeder
{
    private $functionCall;

    public function __construct()
    {
        $this->functionCall = DatabaseSeeder::functionCall();
    }

    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Formulaires
         */
        $this->formulaires = [
            [
                "id_form"     => "modal_addmodepaiement",
                "tag_field"   => "modepaiement",
                "ng_submit"   => 'addElement($event,\'modepaiement\')',
                "title"       => "Mode de paiement",
                "customlang"  => "mode_paiement",
                "icon"        => "assets/media/svg/icons/sidebar/icon-modalitepaiement.svg",
                "icon_type"   => 1,
                "description" => null,
                "z-index"     => "",
                "class"       => "",
                "fields"      => [
                    [
                        "label" => false,
                        "name" => "id",
                        "customlang" => null,
                        "col" => null,
                        "field" => "input",
                        "input" => [
                            "type" => "hidden",
                            "readonly" => false,
                            "disabled" => false,
                            "autocomplete" => null
                        ],
                        "select" => [],
                        "class" => "",
                        "required" => true,
                        "placeholder" => "",
                        "autocomplete" => ""
                    ],
                ],
                "onglets"     => [
                    [
                        "title"       => "",
                        "customlang"  => "",
                        "icon"        => "flaticon2-information",
                        "description" => null,
                        "order"       => 1,
                        "link"        => "#!/dashboard",
                        "fields" =>
                        [
                            [
                                "label" => true,
                                "name" => "nom",
                                "customlang" => "nom",
                                "col" => "12",
                                "field" => "input",
                                "input" => [
                                    "type" => "text",
                                    "readonly" => false,
                                    "disabled" => false,
                                    "autocomplete" => "off"
                                ],
                                "select" => [],
                                "class" => "",
                                "required" => true,
                                "placeholder" => "",
                                "autocomplete" => "off"
                            ],
                            [
                                "label" => true,
                                "title" => "cash",
                                "name" => "nom",
                                "customlang" => null,
                                "col" => "12",
                                "field" => "input",
                                "input" => [
                                    "type" => "checkbox",
                                    "readonly" => false,
                                    "disabled" => false,
                                    "autocomplete" => "off"
                                ],
                                "select" => [],
                                "class" => "",
                                "required" => true,
                                "placeholder" => "",
                                "autocomplete" => ""
                            ]
                        ],
                    ],
                ],
            ],
        ];

        foreach ($this->formulaires as $formulaire)
        {
            $new_formulaire = Formulaire::{$this->functionCall}([
                'id_form' => $formulaire['id_form']
            ], [
                'id_form'        => $formulaire['id_form'],
                'json'           => json_encode($formulaire),
            ]);
        }
    }
}
