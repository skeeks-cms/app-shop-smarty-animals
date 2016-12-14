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
<? if ($widget->dataProvider->query->count()) : ?>
    <h2 class="owl-featured"><?= $widget->label; ?></h2>

    <div class="owl-carousel featured nomargin owl-padding-10" data-plugin-options='{"singleItem": false, "items": "4", "stopOnHover":false, "autoPlay":4500, "autoHeight": false, "navigation": true, "pagination": false}'>
    <? foreach($widget->dataProvider->query->all() as $model): ?>
        <?= $this->render('sameproduct-item', [
            'model' => $model
        ]); ?>
    <? endforeach; ?>
    </div>
<? endif; ?>