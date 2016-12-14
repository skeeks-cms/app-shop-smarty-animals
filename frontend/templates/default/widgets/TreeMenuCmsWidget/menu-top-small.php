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

<ul class="top-links list-inline">
    <!--<li class="">
        <a href="/" title="Главная"><i class="fa fa-home"></i> Главная</a>
    </li>-->
    <? if ($trees = $widget->activeQuery->all()) : ?>
        <? foreach ($trees as $tree) : ?>
            <li><a href="<?= $tree->url; ?>"><?= $tree->name; ?></a></li>
        <? endforeach; ?>
    <? endif; ?>
</ul>
