<?php

namespace App\Http\Controllers;


class ModeleController extends EntityTypeController
{
    public function beforeValidateData(): void
    {
        if($this->request->from_excel)
        {

        }
    }

}
