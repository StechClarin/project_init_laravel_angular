--POUR LE CALCULE DES ELEMENTS DU DASBORD 
    
    -- POUR LE NOMBRE DE  COMMANDES
    DROP FUNCTION IF EXISTS get_nbre_commandes(pos_id int, date_debut date, date_fin date);
    CREATE OR REPLACE FUNCTION get_nbre_commandes(pos_id int = NULL, date_debut date = NULL, date_fin date = NULL)
    returns int
    language plpgsql
    as
    $$
        declare
            nbre_commande integer;
            DECLARE addPosId text = (CASE WHEN ($1 IS NOT NULL) THEN  ' where commandes.point_vente_id=' || $1  ELSE '' END) ;
            DECLARE addDate text  = (CASE WHEN ($2 IS NOT NULL AND $3 IS NOT NULL) THEN (CASE WHEN ($1 IS  NULL) THEN  ' where (commandes.date::date between ''' || $2 || ''' AND ''' || $3 || ''') ' ELSE ' and (commandes.date::date between ''' || $2 || ''' AND ''' || $3 || ''')' END)  ELSE '' END) ;
        begin
            EXECUTE 'select count(*)  from commandes  ' ||  addPosId ||  addDate  into nbre_commande ;
            return nbre_commande;
        end;
    $$;


     -- POUR LE TOTAL DES DEPENSES
    DROP FUNCTION IF EXISTS get_depense_ttcs(pos_id int, date_debut date, date_fin date);
    CREATE OR REPLACE FUNCTION get_depense_ttcs(pos_id int = NULL, date_debut date = NULL, date_fin date = NULL)
    returns int
    language plpgsql
    as
    $$
        declare
            total integer;
            DECLARE addPosId text = (CASE WHEN ($1 IS NOT NULL) THEN  ' depenses.point_vente_id=' || $1  ELSE '' END) ;
            DECLARE addDate text = (CASE WHEN ($2 IS NOT NULL AND $3 IS NOT NULL) THEN (CASE WHEN ($1 IS  NULL) THEN  '  (depenses.date::date between ''' || $2 || ''' AND ''' || $3 || ''')  and ' ELSE ' and (depenses.date::date between ''' || $2 || ''' AND ''' || $3 || ''') and ' END)  ELSE '' END) ;
        begin
             EXECUTE ' select COALESCE(sum(montant_ttc),0)  from depense_poste_depenses,depenses where '|| addPosId ||  addDate  ||'depenses.id=depense_poste_depenses.depense_id and  depenses.etat=1'  into total ;
            return total;
        end;
    $$;


    -- POUR LE TOTAL DES DEPENSES PAYES EN ESP
    DROP FUNCTION IF EXISTS get_depense_en_esps(pos_id int, date_debut date, date_fin date);
    CREATE OR REPLACE FUNCTION get_depense_en_esps(pos_id int = NULL, date_debut date = NULL, date_fin date = NULL)
    returns int
    language plpgsql
    as
    $$
        declare
                total integer;
                DECLARE addPosId text = (CASE WHEN ($1 IS NOT NULL) THEN  'point_vente_id=' || $1  ELSE '' END) ;
                DECLARE addDate text = (CASE WHEN ($2 IS NOT NULL AND $3 IS NOT NULL) THEN (CASE WHEN ($1 IS  NULL) THEN  '  (date::date between ''' || $2 || ''' AND ''' || $3 || ''')  and ' ELSE ' and (date::date between ''' || $2 || ''' AND ''' || $3 || ''') and ' END)  ELSE '' END) ;
            begin
                EXECUTE 'select COALESCE(sum(montant),0) from paiements,mode_paiements where ' || addPosId ||  addDate  || ' depense_id is not null and mode_paiements.id=paiements.mode_paiement_id and  mode_paiements.type=3 '  into total ; 
                return total;
            end;
    $$;



     -- POUR LE TOTAL DETTE FOURNISSEURS
    DROP FUNCTION IF EXISTS get_dette_fornisseurs(pos_id int, date_debut date, date_fin date);
    CREATE OR REPLACE FUNCTION get_dette_fornisseurss(pos_id int = NULL, date_debut date = NULL, date_fin date = NULL)
    returns int
    language plpgsql
    as
    $$
        declare
        total integer;
            DECLARE addPosId  text = (CASE WHEN ($1 IS NOT NULL) THEN  'depenses.point_vente_id=' || $1  ELSE '' END) ;
            DECLARE addPosIdP text = (CASE WHEN ($1 IS NOT NULL) THEN  'paiements.point_vente_id=' || $1  ELSE '' END) ;
            DECLARE addDate   text = (CASE WHEN ($2 IS NOT NULL AND $3 IS NOT NULL) THEN (CASE WHEN ($1 IS  NULL) THEN  '  (depenses.date::date between ''' || $2 || ''' AND ''' || $3 || ''')  and ' ELSE ' and (depenses.date::date between ''' || $2 || ''' AND ''' || $3 || ''') and ' END)  ELSE '' END) ;
        begin
            EXECUTE 'select (select COALESCE(sum(montant_ttc),0) from depense_poste_depenses,depenses where ' || addPosId ||  addDate  || ' depenses.id=depense_poste_depenses.depense_id  and depenses.etat=1 and depenses.tier_id is not null )- (select COALESCE(sum(paiements.montant),0) from paiements,depenses where ' || addPosIdP ||  addDate  ||' paiements.depense_id=depenses.id  and depenses.tier_id is not null  )'  into total;
            return total;
        end;
    $$;

    -- POUR LE NBRE BE
    DROP FUNCTION IF EXISTS get_nbre_bes(pos_id int, date_debut date, date_fin date);
    CREATE OR REPLACE FUNCTION get_nbre_bes(pos_id int = NULL, date_debut date = NULL, date_fin date = NULL)
    returns int
    language plpgsql
    as
    $$
        declare
            total integer;
            DECLARE addPosId  text = (CASE WHEN ($1 IS NOT NULL) THEN  'depots.point_vente_id=' || $1  ELSE '' END) ;
            DECLARE addDate   text = (CASE WHEN ($2 IS NOT NULL AND $3 IS NOT NULL) THEN (CASE WHEN ($1 IS  NULL) THEN  '  (bon_entrees.date::date between ''' || $2 || ''' AND ''' || $3 || ''')  and ' ELSE ' and (bon_entrees.date::date between ''' || $2 || ''' AND ''' || $3 || ''') and ' END)  ELSE '' END) ;
        begin
           EXECUTE ' select count(bon_entrees.id) as nbre from bon_entrees,depots  where ' || addPosId ||  addDate  || ' bon_entrees.depot_id=depots.id  and bon_entrees.etat=1 ' into total;
            return total;
        end;
    $$;


    -- POUR LA VALEUR BE
    DROP FUNCTION IF EXISTS get_valeur_bes(pos_id int, date_debut date, date_fin date);
    CREATE OR REPLACE FUNCTION get_valeur_bes(pos_id int = NULL, date_debut date = NULL, date_fin date = NULL)
    returns int
    language plpgsql
    as
    $$
        declare
            total integer;
            DECLARE addPosId  text = (CASE WHEN ($1 IS NOT NULL) THEN  'depots.point_vente_id=' || $1  ELSE '' END) ;
            DECLARE addDate   text = (CASE WHEN ($2 IS NOT NULL AND $3 IS NOT NULL) THEN (CASE WHEN ($1 IS  NULL) THEN  '  (bon_entrees.date::date between ''' || $2 || ''' AND ''' || $3 || ''')  and ' ELSE ' and (bon_entrees.date::date between ''' || $2 || ''' AND ''' || $3 || ''') and ' END)  ELSE '' END) ;
        begin
            EXECUTE 'select COALESCE(sum(total_ttc),0) as montant  from bon_entree_produits,bon_entrees,depots where ' || addPosId ||  addDate  ||'  bon_entrees.depot_id=depots.id  and bon_entrees.id=bon_entree_produits.bon_entree_id and bon_entrees.etat=1 ' into total;
            return total;
        end;
    $$;


     -- POUR CA DES COMMANDES 
    DROP FUNCTION IF EXISTS get_total_cas(pos_id int, date_debut date, date_fin date);
    CREATE OR REPLACE FUNCTION get_total_cas(pos_id int = NULL, date_debut date = NULL, date_fin date = NULL)
    returns int
    language plpgsql
    as
    $$
        declare
            total integer;
            DECLARE addPosId  text = (CASE WHEN ($1 IS NOT NULL) THEN  'point_vente_id=' || $1  ELSE '' END) ;
            DECLARE addDate   text = (CASE WHEN ($2 IS NOT NULL AND $3 IS NOT NULL) THEN (CASE WHEN ($1 IS  NULL) THEN  '  (date::date between ''' || $2 || ''' AND ''' || $3 || ''')  ' ELSE ' and (date::date between ''' || $2 || ''' AND ''' || $3 || ''') ' END)  ELSE '' END) ;
        begin
            EXECUTE ' select COALESCE(sum(commandes.total),0) as montant from commandes where ' || addPosId ||  addDate  into total ;
            return total;
        end;
    $$;



     -- POUR  TOTAL COMMANDE PAYE
    DROP FUNCTION IF EXISTS get_total_payes(pos_id int, date_debut date, date_fin date);
    CREATE OR REPLACE FUNCTION get_total_payes(pos_id int = NULL, date_debut date = NULL, date_fin date = NULL)
    returns int
    language plpgsql
    as
    $$
        declare
            total integer;
            DECLARE addPosId  text = (CASE WHEN ($1 IS NOT NULL) THEN  'commandes.point_vente_id=' || $1  ELSE '' END) ;
            DECLARE addDate   text = (CASE WHEN ($2 IS NOT NULL AND $3 IS NOT NULL) THEN (CASE WHEN ($1 IS  NULL) THEN  '  (commandes.date::date between ''' || $2 || ''' AND ''' || $3 || ''')  ' ELSE ' and (commandes.date::date between ''' || $2 || ''' AND ''' || $3 || ''') ' END)  ELSE '' END) ;
        begin
             EXECUTE ' select COALESCE(sum(montant),0) as montant from paiements,commandes where ' || addPosId ||  addDate || ' and commande_id=commandes.id '  into total ; 
             return total;
        end;
    $$;


    -- POUR  TOTAL COMMANDE NON PAYE
    DROP FUNCTION IF EXISTS get_total_non_paye(pos_id int, date_debut date, date_fin date);
    CREATE OR REPLACE FUNCTION get_total_non_payes(pos_id int = NULL, date_debut date = NULL, date_fin date = NULL)
    returns int
    language plpgsql
    as
    $$
        declare
            total integer;
            DECLARE addPosId  text = (CASE WHEN ($1 IS NOT NULL) THEN  'commandes.point_vente_id=' || $1  ELSE '' END) ;
            DECLARE addDate   text = (CASE WHEN ($2 IS NOT NULL AND $3 IS NOT NULL) THEN (CASE WHEN ($1 IS  NULL) THEN  '  (commandes.date::date between ''' || $2 || ''' AND ''' || $3 || ''')  and ' ELSE ' and (commandes.date::date between ''' || $2 || ''' AND ''' || $3 || ''') and ' END)  ELSE '' END) ;
        begin
            EXECUTE 'select (select COALESCE(sum(commandes.total_to_pay),0) from commandes where ' || addPosId ||  addDate ||  'commandes.etat_commande!=8 )- (select COALESCE(sum(paiements.montant),0) from paiements,commandes where '|| addPosId ||  addDate ||' paiements.commande_id=commandes.id  and commandes.etat_commande !=8  )'  into total;
            return total;
        end;
    $$;


    -- POUR  TOTAL CREDIT CLIENT
    DROP FUNCTION IF EXISTS get_total_credit(pos_id int, date_debut date, date_fin date);
    CREATE OR REPLACE FUNCTION get_total_credits(pos_id int = NULL, date_debut date = NULL, date_fin date = NULL)
    returns int
    language plpgsql
    as
    $$
        declare
            total integer;
            DECLARE addPosId  text = (CASE WHEN ($1 IS NOT NULL) THEN  'commandes.point_vente_id=' || $1  ELSE '' END) ;
            DECLARE addDate   text = (CASE WHEN ($2 IS NOT NULL AND $3 IS NOT NULL) THEN (CASE WHEN ($1 IS  NULL) THEN  '  (commandes.date::date between ''' || $2 || ''' AND ''' || $3 || ''')  and ' ELSE ' and (commandes.date::date between ''' || $2 || ''' AND ''' || $3 || ''') and ' END)  ELSE '' END) ;
        begin
             EXECUTE ' select COALESCE(sum(montant),0) as montant from historique_clotures,commandes where ' || addPosId ||  addDate ||' commande_id=commandes.id  and is_ci=0  ' into total ; 
            return total;
        end;
    $$;


    -- POUR  TOTAL CONSOMMATION INTERNE 
    DROP FUNCTION IF EXISTS get_total_cis(pos_id int, date_debut date, date_fin date);
    CREATE OR REPLACE FUNCTION get_total_cis(pos_id int = NULL, date_debut date = NULL, date_fin date = NULL)
    returns int
    language plpgsql
    as
    $$
        declare
            total integer;
            DECLARE addPosId  text = (CASE WHEN ($1 IS NOT NULL) THEN  'commandes.point_vente_id=' || $1  ELSE '' END) ;
            DECLARE addDate   text = (CASE WHEN ($2 IS NOT NULL AND $3 IS NOT NULL) THEN (CASE WHEN ($1 IS  NULL) THEN  '(commandes.date::date between ''' || $2 || ''' AND ''' || $3 || ''')  and ' ELSE ' and (commandes.date::date between ''' || $2 || ''' AND ''' || $3 || ''') and ' END)  ELSE '' END) ;
        begin
             EXECUTE 'select COALESCE(sum(montant),0) as montant from historique_clotures,commandes where ' || addPosId ||  addDate ||' commande_id=commandes.id and is_ci=0  ' into total ; 
        return total;
    end;
    $$;


    -- POUR  TOTAL OFFERT ET PERTE 
    DROP FUNCTION IF EXISTS get_total_offert_pertes(pos_id int, date_debut date, date_fin date);
    CREATE OR REPLACE FUNCTION get_total_offert_pertes(pos_id int = NULL, date_debut date = NULL, date_fin date = NULL)
    returns int
    language plpgsql
    as
    $$
        declare
            total integer;
            DECLARE addPosId  text = (CASE WHEN ($1 IS NOT NULL) THEN  'commandes.point_vente_id=' || $1  ELSE '' END) ;
            DECLARE addDate   text = (CASE WHEN ($2 IS NOT NULL AND $3 IS NOT NULL) THEN (CASE WHEN ($1 IS  NULL) THEN  '(commandes.date::date between ''' || $2 || ''' AND ''' || $3 || ''')  and ' ELSE ' and (commandes.date::date between ''' || $2 || ''' AND ''' || $3 || ''') and ' END)  ELSE '' END) ;
        begin
            EXECUTE 'select COALESCE(sum(commande_produits.total),0) as montant from commande_produits,commandes where ' || addPosId ||  addDate || 'commande_produits.commande_id=commandes.id  and (commande_produits.offert=1 or commande_produits.perte=1)' into total ; 
            return total;
        end;
    $$;


    -- POUR  TOTAL OFFERT 
    DROP FUNCTION IF EXISTS get_total_offerts(pos_id int, date_debut date, date_fin date);
    CREATE OR REPLACE FUNCTION get_total_offerts(pos_id int = NULL, date_debut date = NULL, date_fin date = NULL)
    returns int
    language plpgsql
    as
    $$
        declare
            total integer;
            DECLARE addPosId  text = (CASE WHEN ($1 IS NOT NULL) THEN  'commandes.point_vente_id=' || $1  ELSE '' END) ;
            DECLARE addDate   text = (CASE WHEN ($2 IS NOT NULL AND $3 IS NOT NULL) THEN (CASE WHEN ($1 IS  NULL) THEN  '(commandes.date::date between ''' || $2 || ''' AND ''' || $3 || ''')  and ' ELSE ' and (commandes.date::date between ''' || $2 || ''' AND ''' || $3 || ''') and ' END)  ELSE '' END) ;
        begin
            EXECUTE 'select COALESCE(sum(commande_produits.total),0) as montant from commande_produits,commandes where ' || addPosId ||  addDate || 'commande_produits.commande_id=commandes.id  and commande_produits.offert=1 ' into total ; 
            return total;
        end;
    $$;


     -- POUR  TOTAL PERTE 
    DROP FUNCTION IF EXISTS get_total_pertes(pos_id int, date_debut date, date_fin date);
    CREATE OR REPLACE FUNCTION get_total_pertes(pos_id int = NULL, date_debut date = NULL, date_fin date = NULL)
    returns int
    language plpgsql
    as
    $$
        declare
            total integer;
            DECLARE addPosId  text = (CASE WHEN ($1 IS NOT NULL) THEN  'commandes.point_vente_id=' || $1  ELSE '' END) ;
            DECLARE addDate   text = (CASE WHEN ($2 IS NOT NULL AND $3 IS NOT NULL) THEN (CASE WHEN ($1 IS  NULL) THEN  '(commandes.date::date between ''' || $2 || ''' AND ''' || $3 || ''')  and ' ELSE ' and (commandes.date::date between ''' || $2 || ''' AND ''' || $3 || ''') and ' END)  ELSE '' END) ;
        begin
            EXECUTE 'select COALESCE(sum(commande_produits.total),0) as montant from commande_produits,commandes where ' || addPosId ||  addDate || 'commande_produits.commande_id=commandes.id  and commande_produits.perte=1 ' into total ; 
            return total;
        end;
    $$;


    --List Top 3 des produits Be en fonction de la valeur

    DROP FUNCTION IF EXISTS get_top_3_produits_entrees(pos_id int, date_start date, date_end date);
    create or replace function get_top_3_produits_entrees(pos_id int = NULL, date_debut date = NULL, date_fin date = NULL)
    returns table (designation varchar,qte integer,montant integer ) 
    language plpgsql  as $$
        declare 
            item record;
            DECLARE addPosIdProd  text = (CASE WHEN ($1 IS NOT NULL) THEN  'depots.point_vente_id=' || $1  || ' and ' ELSE '' END) ;
            DECLARE addPosId  text = (CASE WHEN ($1 IS NOT NULL) THEN  'depots.point_vente_id=' || $1  ELSE '' END) ;
            DECLARE addDate   text = (CASE WHEN ($2 IS NOT NULL AND $3 IS NOT NULL) THEN (CASE WHEN ($1 IS  NULL) THEN  '(bon_entrees.date::date between ''' || $2 || ''' AND ''' || $3 || ''')  and ' ELSE ' and (bon_entrees.date::date between ''' || $2 || ''' AND ''' || $3 || ''') and ' END)  ELSE '' END) ;
        begin
            for item in  EXECUTE'(
                      select produits.designation,(select COALESCE(sum(bon_entree_produits.total_ttc),0)  as montant from bon_entree_produits,bon_entrees,depots where ' || addPosId ||  addDate || ' bon_entree_produits.produit_id=produits.id and bon_entree_produits.bon_entree_id=bon_entrees.id  and  bon_entrees.depot_id=depots.id )  ,(select  count(bon_entree_produits.produit_id)  as qte from bon_entree_produits,bon_entrees,depots where '|| addPosId ||  addDate ||'  bon_entree_produits.produit_id=produits.id and bon_entree_produits.bon_entree_id=bon_entrees.id and bon_entrees.depot_id=depots.id ) from produits,bon_entree_produits,bon_entrees,depots  where '|| addPosIdProd || ' produits.id=bon_entree_produits.produit_id and bon_entree_produits.bon_entree_id=bon_entrees.id and  bon_entrees.depot_id=depots.id  group by produits.id ORDER BY montant DESC LIMIT 3
                )' loop  designation := upper(item.designation) ; 
                    qte := item.qte;
                    montant := item.montant;
                return next;
            end loop;
        end; 
    $$;

       --List Top 3 des produits Be en fonction de la qte
    DROP FUNCTION IF EXISTS get_top_3_produits_entree_qtes(pos_id int, date_start date, date_end date);
    create or replace function get_top_3_produits_entree_qtes(pos_id int = NULL, date_debut date = NULL, date_fin date = NULL)
    returns table (designation varchar,qte integer ) 
    language plpgsql  as $$
        declare 
            item record;
            DECLARE addPosIdProd  text = (CASE WHEN ($1 IS NOT NULL) THEN  'depots.point_vente_id=' || $1  || ' and ' ELSE '' END) ;
            DECLARE addPosId  text = (CASE WHEN ($1 IS NOT NULL) THEN  'depots.point_vente_id=' || $1  ELSE '' END) ;
            DECLARE addDate   text = (CASE WHEN ($2 IS NOT NULL AND $3 IS NOT NULL) THEN (CASE WHEN ($1 IS  NULL) THEN  '(bon_entrees.date::date between ''' || $2 || ''' AND ''' || $3 || ''')  and ' ELSE ' and (bon_entrees.date::date between ''' || $2 || ''' AND ''' || $3 || ''') and ' END)  ELSE '' END) ;
        begin
            for item in EXECUTE'(
                    select produits.designation,(select  count(bon_entree_produits.produit_id)  as qte from bon_entree_produits,bon_entrees,depots where '  || addPosId ||  addDate ||  ' bon_entree_produits.produit_id=produits.id and bon_entree_produits.bon_entree_id=bon_entrees.id and bon_entrees.depot_id=depots.id )  from produits,bon_entree_produits,bon_entrees,depots  where '|| addPosIdProd || ' produits.id=bon_entree_produits.produit_id and bon_entree_produits.bon_entree_id=bon_entrees.id and  bon_entrees.depot_id=depots.id  group by produits.id ORDER BY qte DESC LIMIT 3
                )' loop  designation := upper(item.designation) ; 
                    qte := item.qte;
                  
                return next;
            end loop;
        end; 
    $$;

     --List Top 3 des produits Be  en fonction de la valeur
    DROP FUNCTION IF EXISTS get_top_3_produits_vendus(pos_id int, date_start date, date_end date);
    create or replace function get_top_3_produits_vendus(pos_id int = NULL, date_debut date = NULL, date_fin date = NULL)
    returns table (designation varchar,qte integer,montant integer ) 
    language plpgsql  as $$
        declare 
            item record;
            DECLARE addPosIdProd  text = (CASE WHEN ($1 IS NOT NULL) THEN  'commandes.point_vente_id=' || $1  || ' and ' ELSE '' END) ;
            DECLARE addPosId  text = (CASE WHEN ($1 IS NOT NULL) THEN  'commandes.point_vente_id=' || $1  ELSE '' END) ;
            DECLARE addDate   text = (CASE WHEN ($2 IS NOT NULL AND $3 IS NOT NULL) THEN (CASE WHEN ($1 IS  NULL) THEN  '(commandes.date::date between ''' || $2 || ''' AND ''' || $3 || ''')  and ' ELSE ' and (commandes.date::date between ''' || $2 || ''' AND ''' || $3 || ''') and ' END)  ELSE '' END) ;
        begin
           for item in   EXECUTE'(
                select produits.designation,(select  COALESCE(sum(commande_produits.total),0)  as montant from commande_produits,commandes where  '  || addPosId ||  addDate || ' commande_produits.produit_id=produits.id and commande_produits.commande_id=commandes.id  and commande_produit_id is null )  ,(select  count(commande_produits.produit_id)  as qte from commande_produits,commandes where  ' || addPosId ||  addDate || '  commande_produits.produit_id=produits.id and commande_produits.commande_id=commandes.id and commande_produit_id is null  )  from produits,commandes,commande_produits  where  '|| addPosIdProd || ' produits.id=commande_produits.produit_id  and  is_menu=0 and commande_produits.commande_id=commandes.id  and produits.is_menu=0   group by produits.id ORDER BY montant DESC LIMIT 3
            )' loop  designation := upper(item.designation) ; 
                    qte := item.qte;
                    montant := item.montant;
                return next;
            end loop;
        end; 
    $$;



    --List Top 3 des produits Be  en fonction de la qte
    DROP FUNCTION IF EXISTS get_top_3_produits_vendu_qtes(pos_id int, date_start date, date_end date);
    create or replace function get_top_3_produits_vendu_qtes(pos_id int = NULL, date_debut date = NULL, date_fin date = NULL)
    returns table (designation varchar,qte integer ) 
    language plpgsql  as $$
        declare 
            item record;
            DECLARE addPosId  text = (CASE WHEN ($1 IS NOT NULL) THEN  'commandes.point_vente_id=' || $1  ELSE '' END) ;
            DECLARE addPosIdProd  text = (CASE WHEN ($1 IS NOT NULL) THEN  'commandes.point_vente_id=' || $1  || ' and ' ELSE '' END) ;

            DECLARE addDate   text = (CASE WHEN ($2 IS NOT NULL AND $3 IS NOT NULL) THEN (CASE WHEN ($1 IS  NULL) THEN  '(commandes.date::date between ''' || $2 || ''' AND ''' || $3 || ''')  and ' ELSE ' and (commandes.date::date between ''' || $2 || ''' AND ''' || $3 || ''') and ' END)  ELSE '' END) ;
        begin
            for item in EXECUTE'(
                    select produits.designation,(select  count(commande_produits.produit_id) as qte from commande_produits,commandes where ' || addPosId ||  addDate || ' commande_produits.produit_id=produits.id and commande_produits.commande_id=commandes.id  and commande_produit_id is null)  from produits,commandes,commande_produits  where  '|| addPosIdProd || ' produits.id=commande_produits.produit_id and commande_produits.commande_id=commandes.id and  is_menu=0  and produits.is_menu=0 group by produits.id ORDER BY qte DESC LIMIT 3
                )' loop  designation := upper(item.designation) ; 
                    qte := item.qte;
                return next;
            end loop;
        end; 
    $$;


     --List Top 3 des menus de la valeur
    DROP FUNCTION IF EXISTS get_top_3_menus_vendus(pos_id int, date_start date, date_end date);
    create or replace function get_top_3_menus_vendus(pos_id int = NULL, date_debut date = NULL, date_fin date = NULL)
    returns table (designation varchar,qte integer,montant integer ) 
    language plpgsql  as $$
        declare 
            item record;
            DECLARE addPosIdProd  text = (CASE WHEN ($1 IS NOT NULL) THEN  'commandes.point_vente_id=' || $1  || ' and ' ELSE '' END) ;
            DECLARE addPosId  text = (CASE WHEN ($1 IS NOT NULL) THEN  'commandes.point_vente_id=' || $1  ELSE '' END) ;
            DECLARE addDate   text = (CASE WHEN ($2 IS NOT NULL AND $3 IS NOT NULL) THEN (CASE WHEN ($1 IS  NULL) THEN  '(commandes.date::date between ''' || $2 || ''' AND ''' || $3 || ''')  and ' ELSE ' and (commandes.date::date between ''' || $2 || ''' AND ''' || $3 || ''') and ' END)  ELSE '' END) ;
        begin
           for item in   EXECUTE'(
                select produits.designation,(select  COALESCE(sum(commande_produits.total),0)  as montant from commande_produits,commandes where  '  || addPosId ||  addDate || ' commande_produits.produit_id =produits.id and commande_produits.commande_id=commandes.id  and commande_produit_id is null )  ,(select  count(commande_produits.produit_id)  as qte from commande_produits,commandes where  ' || addPosId ||  addDate || '  commande_produits.produit_id=produits.id and commande_produits.commande_id=commandes.id and commande_produit_id is null  )  from produits,commandes,commande_produits  where  '|| addPosIdProd || ' produits.id=commande_produits.produit_id and is_menu=1 and  commande_produits.commande_id=commandes.id   group by produits.id ORDER BY montant DESC LIMIT 3
            )' loop  designation := upper(item.designation) ; 
                    qte := item.qte;
                    montant := item.montant;
                return next;
            end loop;
        end; 
    $$;



    --List Top 3 des menus en fonction de la qte
    DROP FUNCTION IF EXISTS get_top_3_menus_vendu_qtes(pos_id int, date_start date, date_end date);
    create or replace function get_top_3_menus_vendu_qtes(pos_id int = NULL, date_debut date = NULL, date_fin date = NULL)
    returns table (designation varchar,qte integer ) 
    language plpgsql  as $$
        declare 
            item record;
            DECLARE addPosId  text = (CASE WHEN ($1 IS NOT NULL) THEN  'commandes.point_vente_id=' || $1  ELSE '' END) ;
            DECLARE addPosIdProd  text = (CASE WHEN ($1 IS NOT NULL) THEN  'commandes.point_vente_id=' || $1  || ' and ' ELSE '' END) ;

            DECLARE addDate   text = (CASE WHEN ($2 IS NOT NULL AND $3 IS NOT NULL) THEN (CASE WHEN ($1 IS  NULL) THEN  '(commandes.date::date between ''' || $2 || ''' AND ''' || $3 || ''')  and ' ELSE ' and (commandes.date::date between ''' || $2 || ''' AND ''' || $3 || ''') and ' END)  ELSE '' END) ;
        begin
            for item in EXECUTE'(
                    select produits.designation,(select  count(commande_produits.produit_id) as qte from commande_produits,commandes where ' || addPosId ||  addDate || ' commande_produits.produit_id=produits.id and commande_produits.commande_id=commandes.id  and commande_produit_id is null)  from produits,commandes,commande_produits  where  '|| addPosIdProd || ' produits.id=commande_produits.produit_id and commande_produits.commande_id=commandes.id  and produits.is_menu=1  group by produits.id ORDER BY qte DESC LIMIT 3
                )' loop  designation := upper(item.designation) ; 
                    qte := item.qte;
                return next;
            end loop;
        end; 
    $$;




    --List Top 3 des produits  commandes en fonction de la valeur

    DROP FUNCTION IF EXISTS get_repartitionss(pos_id int, date_start date, date_end date);
    create or replace function get_repartitionss(pos_id int = NULL, date_debut date = NULL, date_fin date = NULL)
    returns table (nom varchar,montant integer ) 
    language plpgsql  as $$
        declare 
            item record;
            DECLARE addPosId     text = (CASE WHEN ($1 IS NOT NULL) THEN  'commandes.point_vente_id=' || $1  ELSE '' END) ;
            DECLARE addPosIdMod  text = (CASE WHEN ($1 IS NOT NULL) THEN  'commandes.point_vente_id=' || $1  || ' and ' ELSE '' END) ;

            DECLARE addDate      text = (CASE WHEN ($2 IS NOT NULL AND $3 IS NOT NULL) THEN (CASE WHEN ($1 IS  NULL) THEN  '(commandes.date::date between ''' || $2 || ''' AND ''' || $3 || ''')  and ' ELSE ' and (commandes.date::date between ''' || $2 || ''' AND ''' || $3 || ''') and ' END)  ELSE '' END) ;
        begin
            for item in EXECUTE'(
                    select mode_paiements.nom,(select  COALESCE(sum(paiements.montant),0)  as montant from paiements,commandes where ' || addPosId ||  addDate ||  ' paiements.mode_paiement_id=mode_paiements.id and paiements.commande_id=commandes.id  )  from mode_paiements,paiements,commandes where ' || addPosIdMod || 'mode_paiements.id=paiements.mode_paiement_id  and paiements.commande_id=commandes.id  group by mode_paiements.id ORDER BY montant DESC 
                    )' 
                    loop  nom := upper(item.nom) ; 
                    montant := item.montant;
                return next;
            end loop;
        end; 
    $$;


    