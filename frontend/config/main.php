<?php
/**
 * Конфиг сайтвой части приложения
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010-2014 SkeekS (Sx)
 * @date 15.10.2014
 * @since 1.0.0
 */
$config = [
    'params' => [],
    'on beforeRequest' => function ($event) {
        \Yii::setAlias('template', '@app/views');
        //  if (\Yii::$app->admin->requestIsAdmin)
        // {
        //\Yii::$app->httpBasicAuth->verify();
        //}
    },
    'components' =>
        [

            'request' => [
                // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
                'cookieValidationKey' => 'Asfsdfsdf648re8984$32',
            ],
            'user' =>
                [
                    'identityClass' => 'common\models\User',
                    /*'identityCookie' => [
                        'name' => '_identity',
                        'httpOnly' => true,
                        'domain' => '.cms.skeeks.com'
                    ]*/
                ],

        ]
];
return $config;
