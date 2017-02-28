<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 25.05.2015
 */
/* @var $this   yii\web\View */
/* @var $widget \skeeks\cms\cmsWidgets\treeMenu\TreeMenuCmsWidget */
/* @var $trees  \skeeks\cms\models\Tree[] */

?>

<ul id="topMain" class="nav nav-pills nav-main sx-top-menu">
    <!--<li class="">
        <a href="/" title="Главная"><i class="fa fa-home"></i> Главная</a>
    </li>-->
    <? if ($trees = $widget->activeQuery->all()) : ?>
        <? foreach ($trees as $tree) : ?>
            <?= $this->render("_one", [
                "widget"        => $widget,
                "model"         => $tree,
            ]); ?>
        <? endforeach; ?>
    <? endif; ?>
</ul>
