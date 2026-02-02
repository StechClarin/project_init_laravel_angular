<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

class GestionStockSeeder extends Seeder
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


    /*POUR ECRIRE DANS LES MOUVEMENTS STOCK DIRECTEMENT*/
        DROP FUNCTION IF EXISTS write_in_mouvement_stocks() CASCADE;
        
        CREATE OR REPLACE FUNCTION write_in_mouvement_stocks() RETURNS trigger AS \$mouvements_stock\$
        DECLARE quantite_1 double precision;quantite_2 double precision;produit_id numeric;manage_stock boolean;
        BEGIN
            IF (TG_TABLE_NAME = 'entree_sortie_stock_produits') THEN
                IF (TG_OP = 'UPDATE' OR TG_OP = 'DELETE') THEN
                    IF (OLD.etat = 1) THEN
                        produit_id = OLD.produit_id;
                        quantite_1 = -1 * (OLD.multiplicateur * OLD.quantite);
                    END IF;
                END IF;
                IF (TG_OP != 'DELETE') THEN
                    IF (NEW.etat = 1) THEN
                        produit_id = NEW.produit_id;
                        quantite_2 = (NEW.multiplicateur * NEW.quantite);
                    END IF;
                END IF;
            END IF;
        
            IF (quantite_1 IS NOT NULL AND OLD.produit_id IS NOT NULL) THEN
            --raise notice 'INSERT INTO mouvement_stocks (produit_id,depot_id,qte,transaction_name,transaction_id) values (%, %,%, ''%'', %, ''%'', ''%'');', OLD.produit_id,OLD.depot_id, quantite_1, TG_TABLE_NAME, OLD.id, NOW();
                EXECUTE format ('INSERT INTO mouvement_stocks (produit_id,depot_id,qte,transaction_name,transaction_id,created_at,updated_at) values (%s, %s, %s,''%s'', %s, ''%s'', ''%s'');', OLD.produit_id,OLD.depot_id, quantite_1, TG_TABLE_NAME, OLD.id, NOW(), NOW());
            END IF;
            IF (quantite_2 IS NOT NULL AND NEW.produit_id IS NOT NULL) THEN
                --raise notice 'INSERT INTO mouvement_stocks (produit_id,depot_id,qte,transaction_name,transaction_id) values (%, %, %,''%'', %, ''%'', ''%'');', NEW.produit_id,NEW.depot_id, quantite_2, TG_TABLE_NAME, NEW.id, NOW();
                EXECUTE format ('INSERT INTO mouvement_stocks (produit_id,depot_id,qte,transaction_name,transaction_id,created_at,updated_at) values (%s, %s, %s,''%s'', %s, ''%s'', ''%s'');', NEW.produit_id,NEW.depot_id, quantite_2, TG_TABLE_NAME, NEW.id, NOW(), NOW());
            END IF;
        
            RETURN NEW;
        END;
        \$mouvements_stock\$ LANGUAGE plpgsql;
        
        
        
        /*TRIGER POUR ECRIRE DANS LA TABLE MVT_PRODUIT  EN CAS DE MAJ SUR  DETAIL ENTREE SORTIE STOCK*/
        DROP TRIGGER IF EXISTS mouvement_entree_sortie_stocks ON entree_sortie_stock_produits CASCADE;
        CREATE TRIGGER mvt_produits AFTER INSERT OR UPDATE OR DELETE ON entree_sortie_stock_produits
            FOR EACH ROW EXECUTE FUNCTION write_in_mouvement_stocks();


    /* FONCTION POUR ECRIRE DANS LA TABLE MOUVEMENT STOCK PRODUIT DEPOT */

        CREATE OR REPLACE FUNCTION write_in_mouvement_stock_produit_depots() RETURNS trigger AS \$mouvement_stock_produit_depots\$
        BEGIN
            --raise notice 'INSERT INTO mouvement_stock_produit_depots (produit_id,depot_id,qte,last_dates) values (%, %, %, ''%'', ''%'', ''%'');', NEW.produit_id, NEW.depot_id,NEW.qte, NOW();
            EXECUTE format ('INSERT INTO mouvement_stock_produit_depots (produit_id,depot_id,qte,last_dates,created_at,updated_at) values (%s, %s, %s, ''%s'',''%s'', ''%s'');', NEW.produit_id,NEW.depot_id, NEW.qte,  NOW(),NOW(), NOW());
        
            raise notice 'update produits set current_qte = % where id = %;', NEW.qte, NEW.produit_id;
            EXECUTE format ('UPDATE produits set current_qte = current_qte + %s where id = %s;', NEW.qte, NEW.produit_id);
            
            RETURN NEW;
        END;
        \$mouvement_stock_produit_depots\$ LANGUAGE plpgsql;
        
        ALTER FUNCTION write_in_mouvement_stock_produit_depots() OWNER TO postgres;
        
        /* TRIGGER POUR L'ECRITURE DE LA TABLE  MVT_PRODUIT_DEPOT*/
        DROP TRIGGER IF EXISTS mouvement_stock_produit_depots ON mouvement_stocks CASCADE;
        CREATE TRIGGER mouvement_stock_produit_depots AFTER INSERT  ON mouvement_stocks
            FOR EACH ROW EXECUTE FUNCTION write_in_mouvement_stock_produit_depots();

                ");
        
        DB::commit();
    }

    //
}
