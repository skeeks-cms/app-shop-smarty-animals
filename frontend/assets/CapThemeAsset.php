<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (—ÍËÍ—)
 * @date 29.07.2015
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Class ArtificialThemeAsset
 * @package frontend\assets
 */
class CapThemeAsset extends AppAsset
{
    public $basePath = '@webroot/cap';
    public $baseUrl = '@web/cap';

    public $css = [
        'http://fonts.googleapis.com/css?family=Open+Sans:400,300,700&subset=latin,cyrillic-ext,latin-ext,cyrillic',
        'css/reset.css',
        'css/styles.css',
    ];
    public $js = [];

    public $depends = [
        '\frontend\assets\AppAsset',
    ];
}