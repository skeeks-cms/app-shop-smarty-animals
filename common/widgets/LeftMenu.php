<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 10.11.2015
 */
namespace common\widgets;

use skeeks\cms\models\Tree;
use yii\base\Widget;

class LeftMenu extends Widget
{
    /**
     * @var Tree
     */
    public $tree;

    /**
     * @var string
     */
    public $viewFile = "left-menu";

    public function run()
    {
        return $this->render($this->viewFile, [
            'widget' => $this
        ]);
    }
}