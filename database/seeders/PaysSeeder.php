<?php

namespace Database\Seeders;

use App\Models\{Pay};
use Illuminate\Database\Seeder;

class PaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pays_cedeao = [
            "Bénin",
            "Burkina Faso",
            "Cap-Vert",
            "Côte d'Ivoire",
            "Gambie",
            "Ghana",
            "Guinée",
            "Guinée-Bissau",
            "Libéria",
            "Mali",
            "Niger",
            "Nigéria",
            "Sénégal",
            "Sierra Leone",
            "Togo"
        ];


        $pays = json_decode(file_get_contents(resource_path('data/countries.json')));

        foreach ($pays as $p) {
            $cedeao = false;
            if (in_array($p, $pays_cedeao)) {
                $cedeao = true;
            }
        
            $existingPays = Pay::query()->where('nom', $p)->first();
            if (!$existingPays) {
                $newPays = new Pay();
                $newPays->nom = $p;
                $newPays->save();
            } else {
                $existingPays->save();
            }
        
            Pay::firstOrCreate(['nom' => $p]);
        }
    }
}
