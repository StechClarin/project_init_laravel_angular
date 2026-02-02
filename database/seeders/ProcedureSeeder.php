<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

class ProcedureSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        DB::unprepared("
        DROP FUNCTION IF EXISTS public.getValorisationPrix(IN produit_id bigint, IN colonnetest varchar(191));
        
            CREATE OR REPLACE FUNCTION public.getValorisationPrix(IN produit_id bigint, IN colonnetest varchar(191))
            RETURNS numeric AS
            $$
            DECLARE colonne numeric;
            DECLARE prix_valorise numeric;
            BEGIN
                IF $2 ~ '^[0-9\.]+$' THEN
                    colonne = $2::numeric;
                    select COALESCE((select produit_prix_ventes.valeur from produit_prix_ventes where produit_prix_ventes.produit_id=$1 AND produit_prix_ventes.type_prix_vente_id=colonne),0) into prix_valorise;
                ELSE
                
                EXECUTE \'select \'  || colonnetest ||  \'from produits where produits.id=\' || $1 into prix_valorise;

                END IF;
                RETURN prix_valorise;
            END
            $$
            LANGUAGE plpgsql;

                ALTER FUNCTION public.getValorisationPrix(IN produit_id bigint, IN colonnetest varchar(191))
                OWNER TO postgres;
            "   
        );
        DB::commit();
    }
}
