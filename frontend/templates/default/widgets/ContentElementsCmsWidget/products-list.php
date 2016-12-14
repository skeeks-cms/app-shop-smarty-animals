<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 25.05.2015
 */
/* @var $this   yii\web\View */
/* @var $widget \skeeks\cms\cmsWidgets\contentElements\ContentElementsCmsWidget */
?>
<? if ($widget->label) : ?>
    <h1 class="size-17 margin-bottom-20"><?= $widget->label; ?></h1>
<? endif; ?>
<? if ($widget->enabledPjaxPagination = \skeeks\cms\components\Cms::BOOL_Y) : ?>
    <? $pjax = \skeeks\cms\modules\admin\widgets\Pjax::begin(); ?>
    <?
    $this->registerJs(<<<JS
(function(sx, $, _)
{
    new sx.classes.Pjax({'id': '{$pjax->id}'});
})(sx, sx.$, sx._);
JS
    );
    ?>
<? endif; ?>
<? echo \yii\widgets\ListView::widget([
    'dataProvider' => $widget->dataProvider,
    'itemView' => \Yii::$app->settings->product_view == 'list' ? "_product-list-item" : 'product-item',
    'emptyText' => '',
    'options' =>
        [
            'class' => 'shop-item-list-v2 row list-inline nomargin',
            'tag' => 'ul',
        ],
    'itemOptions' => [
        'tag' => false
    ],
    'layout' => "\n{items}\n<p class=\"row\">{summary}{pager}</p>"
]) ?>
<? if ($widget->enabledPjaxPagination = \skeeks\cms\components\Cms::BOOL_Y) : ?>
    <? \skeeks\cms\modules\admin\widgets\Pjax::end(); ?>
<? endif; ?>