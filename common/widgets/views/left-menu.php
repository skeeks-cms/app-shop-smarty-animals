<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 10.11.2015
 */
/* @var $this yii\web\View */
/* @var $widget \common\widgets\LeftMenu */
$this->registerCss(<<<CSS
    div.side-nav ul.list-group-noicon>li
    {
        list-style: none;
    }

    .sx-left-menu ul
    {
        padding-left: 10px !important;
    }
    div.side-nav ul>li.active>a
    {
        font-weight: bold;
    }

CSS
);
/*if ($widget->tree->level > 1)
{
    $parent = $widget->tree->parents[1];
} else
{
    $parent = $widget->tree;
}*/
if ($widget->tree && $widget->tree->level > 1) {
    $parent = \Yii::$app->cms->currentTree;
} else {
    $parent = $widget->tree;
}
?>
<? if ($widget->tree) : ?>
    <!-- <h2 class="owl-featured">Каталог</h2>-->
    <ul class="sx-left-menu list-group list-group-bordered list-group-noicon uppercase">
        <? if ($parent->children) : ?>
            <? foreach ($parent->getChildren()->andWhere(['active' => "Y"])->all() as $childTree) : ?>
                <?= $this->render("_left-menu", [
                    'model' => $childTree,
                    'activeModel' => $widget->tree,
                ]); ?>
            <? endforeach; ?>
        <? else : ?>
            <? foreach ($parent->parent->getChildren()->andWhere(['active' => "Y"])->all() as $childTree) : ?>
                <?= $this->render("_left-menu", [
                    'model' => $childTree,
                    'activeModel' => $widget->tree,
                ]); ?>
            <? endforeach; ?>
        <? endif; ?>
    </ul>
<? endif; ?>