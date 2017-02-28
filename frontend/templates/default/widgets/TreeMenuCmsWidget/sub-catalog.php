<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 25.05.2015
 */
/* @var $this   yii\web\View */
/* @var $widget \skeeks\cms\cmsWidgets\treeMenu\TreeMenuCmsWidget */
/* @var $models  \skeeks\cms\models\Tree[] */
?>
<? if ($models = $widget->activeQuery->all()) : ?>
    <ul class="shop-item-list row list-inline nomargin">
        <? foreach ($models as $model) : ?>
            <?= $this->render("_one_subcatalog", [
                "widget"        => $widget,
                "model"         => $model,
            ]); ?>
        <? endforeach; ?>
    </ul>
<? endif; ?>