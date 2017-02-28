<?php
/**
 * Общий конфиг для всего приложения
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010-2014 SkeekS (Sx)
 * @date 15.10.2014
 * @since 1.0.0
 */
$config = [
    'name' => 'SkeekS CMS',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',

    'on beforeRequest' => function ($event) {
        \Yii::setAlias('template', '@app/views');
    },

    'components'    =>
    [
        'db' => include_once __DIR__ . '/db.php',

        'urlManager' => [
            'rules' => [
                'search'                                => 'cmsSearch/result',
                [
                    'class'             => \skeeks\cms\components\urlRules\UrlRuleContentElement::className(),
                ],

                [
                    'class'             => \skeeks\cms\components\urlRules\UrlRuleTree::className(),
                ]
            ]
        ],


        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'assetManager' =>
        [
            'linkAssets'        => false,
        ],

        'settings' =>
        [
            'class'        => 'common\components\SettingsComponent',
        ],

        'cmsAgent' => [
            'onHitsEnabled'     => true
        ],
    ],
];


return $config;
