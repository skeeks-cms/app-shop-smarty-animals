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
    <ul class="list-unstyled nomargin nopadding text-left sx-visited-products">
        <? foreach ($widget->dataProvider->query->all() as $model): ?>
            <?
            /**
             * @var $model \skeeks\cms\shop\models\ShopCmsContentElement
             */
            $shopProduct = \skeeks\cms\shop\models\ShopProduct::getInstanceByContentElement($model); ?>
            <li class="clearfix"><!-- item -->
                <div class="thumbnail featured clearfix pull-left" style="margin-right: 20px;">
                    <a href="<?= $model->url; ?>" title="<?= $model->name; ?>" data-pjax="0">
                        <img src="<?= \Yii::$app->settings->imageLoader; ?>"
                             data-original="<?= \Yii::$app->imaging->getImagingUrl($model->image ? $model->image->src : null,
                                 new \skeeks\cms\components\imaging\filters\Thumbnail([
                                     'w' => 264,
                                     'h' => 200,
                                 ])
                             ); ?>" width="80" height="80" title="<?= $model->name; ?>" alt="<?= $model->name; ?>"
                             class="img_list_catalog sx-lazy"/>
                    </a>
                </div>
                <a class="block size-12" href="<?= $model->url; ?>"
                   title="<?= $model->name; ?>"><?= $model->name; ?></a>

                <div class="size-18 text-left">
                    <? if ($shopProduct->minProductPrice->id == $shopProduct->baseProductPrice->id) : ?>
                        <?= \Yii::$app->money->convertAndFormat($shopProduct->minProductPrice->money); ?>
                    <? else : ?>
                        <span
                            class="line-through"><?= \Yii::$app->money->convertAndFormat($shopProduct->baseProductPrice->money); ?></span>
                        <?= \Yii::$app->money->convertAndFormat($shopProduct->minProductPrice->money); ?>
                    <? endif; ?>
                </div>
            </li>
        <? endforeach; ?>
    </ul>
<? endif; ?>