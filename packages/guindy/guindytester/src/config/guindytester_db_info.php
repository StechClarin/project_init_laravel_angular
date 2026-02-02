<?php

return [

    'client' => [
        'tablename' => 'clients',
        'foreignids' => [
            'type_client_id' => 'typeclient',
            'classe_id' => 'classe',
        ],
    ],

    'typeclient' => [
        'tablename' => 'typeclients',
        'foreignids' => [],
    ],

];
