<?php 

namespace App\Gestions;

use App\Gestions\PhotoGestionInterface;
use App\Models\ProduitImage;
use App\Models\Outil;

class PhotoGestion  implements PhotoGestionInterface
{


    public static function getQueryNameOfModel($nameTable)
    {
        return str_replace("_", "", $nameTable);
    }


   
    public static function generateCode($id)
    {
        $count = "";
        $id = intval($id);
        if ($id <= 9) {
            $count = "000" . $id;
        } else if ($id >= 10 && $id <= 99) {
            $count = "00" . $id;
        } else if ($id >= 100 && $id <= 999) {
            $count = "0" . $id;
        } else if ($id > 999) {
            $count = $id;
        } else {
            $count = $id;
        }

        return $count;
    }

    //Permet d'enregistrer tout les photos du systeme   1 a 1
    public  function save(&$request, &$item, $file = "image")
    {
        $attr_erase = $file . "_erase";
        if (!empty($request->file()))
        {   
            $fichier = $_FILES[$file]['name'];
            $fichier_tmp = $_FILES[$file]['tmp_name'];
            $ext = explode('.', $fichier);
            $tableNameCollei = self::getQueryNameOfModel($item->getTable());
            $dossier = "uploads/".$tableNameCollei;
            Outil::creerDossier($dossier);
            $rename = $dossier . "/{$file}_" . $item->id . "." . end($ext);
            //$rename = config('view.uploads')[self::getQueryNameOfModel($item->getTable())] . "/{$file}_" . $item->id . "." . end($ext);
            move_uploaded_file($fichier_tmp, $rename);

            $item->image = $rename;
        }
        else if (isset($request->$attr_erase))
        { 
            $item->image = null;
        }
        $item->save();
    }

    //Permet d'enregistrer tout les photos du systeme   Plusieurs
    public  function SaveMany(&$request, &$item, $file = "image",$url=null)
    {
           $nuber = self::generateCode($item->id);
           $fichier = $_FILES[$file]['name'];
           $fichier_tmp = $_FILES[$file]['tmp_name'];
           $ext = explode('.', $fichier);
           if( end($ext)=="" && $url)
           {
               $ext = explode('.', $url);
           }
           $rename = config('view.uploads')[self::getQueryNameOfModel($item->getTable())] . "/{$file}_". $item->id.'_'. $nuber . "." . end($ext);
           move_uploaded_file($fichier_tmp, $rename);

           $newImage =  new ProduitImage();
           $newImage->url = $rename;
           $newImage->image = $rename;
           $newImage->produit_id = $item->id;
           $newImage->name = $file;
           $newImage->identify = "aff" . $file ;
           $newImage->save();
   }
}