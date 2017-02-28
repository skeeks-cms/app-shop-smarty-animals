<?php

$config = [
    /*'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'skeeks1',
        ],
    ],*/

    'bootstrap' => ['debug'],
    'modules' => [
        'gii' =>
        [
            'allowedIPs' => ['*'],
            'class' => '\yii\gii\Module',
        ],

        'debug' =>
        [
            'allowedIPs' => ['*'], // adjust this to your needs
            'class' => 'yii\debug\Module',
        ]
    ],
];

return $config;
