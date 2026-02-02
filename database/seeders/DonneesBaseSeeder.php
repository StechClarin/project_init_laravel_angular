<?php
namespace Database\Seeders;

use App\Models\{DetailTypeDossier,
    ModeFacturation,
    ModeReglement,
    Preference,
    TypeDossier
};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Mpdf\Utils\UtfString;

class DonneesBaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Extension un accent
        DB::statement('CREATE EXTENSION IF NOT EXISTS "unaccent";');

        DB::transaction(function ()
        {
            // Preference
            $items = array();
            array_push($items, array("nom" => "numero_whatsapp", "display_name" => "Numero whatsApp" ,"valeur" => "77777777","link" => ""));
            foreach ($items as $item)
            {
                $newitem = Preference::where('nom', strtolower($item['nom']))->first();
                if (!isset($newitem))
                {
                    $newitem                   = new Preference();
                    $newitem->nom              = strtolower($item['nom']);
                }
                $newitem->valeur               = strtolower($item['valeur']);
                $newitem->display_name         = strtolower($item['display_name']);
                $newitem->save();
            }
        });
    }
}
