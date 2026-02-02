<?php 

namespace App\Gestions;

interface PhotoGestionInterface
{
  //On peut  creer plusieur implementation de cette interface ,mais a un instant T  il faut definir la classe qui vas fonctionner  avec ;
  //Permet de ne pas a chaque fois modifier le code source  juste on creer une nouvelle implementation  et on la fait fonctionne

  public function save(&$request, &$item, $file = "image");

  public  function SaveMany(&$request, &$item, $file = "image",$url=null);
}