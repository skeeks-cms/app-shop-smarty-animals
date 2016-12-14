<?php
/**
 * AppAsset
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010-2014 SkeekS (Sx)
 * @date 20.10.2014
 * @since 1.0.0
 */

namespace frontend\assets;

use skeeks\template\smarty\SmartyAsset;

/**
 * Class LightBoxAsset
 * @package frontend\assets
 */
class LightBoxAsset extends AppAsset
{
    public $css = [];

    public $js = [
        'js/classes/LightBox.js',
    ];

    public $depends = [
        '\frontend\assets\LightBoxSmartyAsset',
    ];
}