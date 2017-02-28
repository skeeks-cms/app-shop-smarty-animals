<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 25.05.2015
 */
/* @var $this   yii\web\View */
/* @var $widget \skeeks\cms\cmsWidgets\contentElements\ContentElementsCmsWidget */
$this->registerCss(<<<CSS
.blog-post-item figure
{
    height: 150px;
}
CSS
);
?>

<? if ($widget->enabledPjaxPagination = \skeeks\cms\components\Cms::BOOL_Y) : ?>
    <? \skeeks\cms\modules\admin\widgets\Pjax::begin(); ?>
<? endif; ?>

<? echo \yii\widgets\ListView::widget([
    'dataProvider'      => $widget->dataProvider,
    'itemView'          => 'brand-item',
    'emptyText'          => '',
    'options'           =>
    [
        'tag'   => 'div',
    ],
    'itemOptions' => [
        'tag' => false
    ],
    'layout'            => "\n{items}\n<p class=\"row\">{pager}</p>"
])?>

<? if ($widget->enabledPjaxPagination = \skeeks\cms\components\Cms::BOOL_Y) : ?>
    <? \skeeks\cms\modules\admin\widgets\Pjax::end(); ?>
<? endif; ?>