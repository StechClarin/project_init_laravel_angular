<?php

namespace App\Models;

class CanalSlack extends Model
{


    public static $columnsExport =  [
        [
            "column_db" => "nom",
            "column_excel" => "Nom",
            "column_unique" => true
        ],
        [
            "column_db" => "slack_id",
            "column_excel" => "Identifiant Slack",
            "column_unique" => false
        ],
    ];

    public function getWebhookLink(){
        $link =  route('webhook', ['canalslack' => $this->id]);
        return $link;
    }
}
