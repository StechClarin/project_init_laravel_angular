<?php 

namespace App\Gestions;



class CodeGestion  implements CodeGestionInterface
{

    public static function getDateEng($date, $format = null)
   {
        $date_at = date_create($date);
        return date_format($date_at, $format);
   }
   public static function generateCode($id)
    {
        $count = "";
        $id = intval($id);
        if ($id <= 9) 
        {
            $count = "000" . $id;
        } 
        else if ($id >= 10 && $id <= 99)
        {
            $count = "00" . $id;
        }
         else if ($id >= 100 && $id <= 999)
        {
            $count = "0" . $id;
        } else if ($id > 999) 
        {
            $count = $id;
        }
        else
        {
            $count = $id;
        }

        return $count;
    }



    // Pour genere  les code de tout l'application 
    public  function save($item, $indicatif)
    {
        $dateCode = '';
        $dateCode = self::getDateEng(now(),'Y-m-d');
        $dateCode = str_replace('-','',$dateCode);
        $code = $indicatif. '-' . $dateCode . '' . self::generateCode($item->id);
        $item->code = $code;
       // dd($item);
        $item->save();
    }

}