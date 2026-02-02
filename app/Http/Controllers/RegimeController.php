<?php

namespace App\Http\Controllers;


class RegimeController extends EntityTypeController
{
    public function beforeValidateData(): void
    {

    }

    public function afterCRUDProcessing(&$model): void
    {
        $detailsins = parseArray($this->request->detailsins, ['id', 'agre']);
        $detailsouts = parseArray($this->request->detailsouts, ['id']);


        $detailsinsSync = collect($detailsins)->pluck('id')->toArray();
        $detailsoutsSync = collect($detailsouts)->pluck('id')->toArray();


        foreach($detailsinsSync as $key => $value)
        {
            $updateAttrs = [
                'multiplicateur' => 1,
            ];

            if (str_contains($this->request->path(), 'typeclient'))
            {
                $updateAttrs['agre'] = isset($detailsins[$key]['agre']) ? $detailsins[$key]['agre'] : 0;
            }
            $detailsinsSync[$value] = $updateAttrs;
        }
        foreach($detailsoutsSync as $key => $value)
        {
            $updateAttrs = [
                'multiplicateur' => 0,
            ];

            if (str_contains($this->request->path(), 'typeclient'))
            {
                $updateAttrs['agre'] = isset($detailsouts[$key]['agre']) ? $detailsouts[$key]['agre'] : 0;
            }
            $detailsoutsSync[$value] = $updateAttrs;
        }
    }
}
