<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 06.03.2015
 *
 * @var \skeeks\cms\models\CmsContentElement $model
 *
 */
/* @var $this yii\web\View */
$shopProduct = \skeeks\cms\shop\models\ShopProduct::getInstanceByContentElement($model);
$product = \common\models\Moto::instance($model);
$model->name = $model->name . " ({$model->relatedPropertiesModel->getSmartAttribute('brand')})";
?>
<li class="col-lg-4 col-sm-4 col-xs-6">
    <div class="shop-item">
        <div class="thumbnail catalog_list">
            <!-- product image(s) -->
            <a class="shop-item-image" href="<?= $model->url; ?>" data-pjax="0">
                <img src="<?= \Yii::$app->settings->imageLoader; ?>" data-original="<?= \skeeks\cms\helpers\Image::getSrc(
                    \Yii::$app->imaging->getImagingUrl($model->image ? $model->image->src : null,
                        new \skeeks\cms\components\imaging\filters\Thumbnail([
                            'w' => 0,
                            'h' => 200,
                        ])
                    )); ?>" title="<?= $model->name; ?>" alt="<?= $model->name; ?>" class="img_list_catalog sx-lazy"/>
            </a>
            <!-- /product image(s) -->
            <!-- hover buttons -->
            <div class="shop-option-over">
                <!-- replace data-item-id width the real item ID - used by js/view/demo.shop.js -->
                <a class="btn btn-default" data-pjax="0" href="<?= $model->url; ?>"><i
                        class="fa fa-cart-plus size-20"></i></a>
            </div>
            <!-- /hover buttons -->
            <!-- product more info -->
            <? if ($shopProduct && $shopProduct->minProductPrice && $shopProduct->baseProductPrice) : ?>
                <? if ($shopProduct->minProductPrice->id != $shopProduct->baseProductPrice->id) : ?>
                    <div class="shop-item-info">
                        <span class="label label-danger">Скидка: <?= \Yii::$app->formatter->asPercent(
                                (100 - ($shopProduct->minProductPrice->money->convertToCurrency("RUB")->getAmount() * 100 / $shopProduct->baseProductPrice->money->convertToCurrency("RUB")->getAmount())) / 100
                            ); ?></span>
                    </div>
                <? endif; ?>
            <? endif; ?>
            <!--<div class="shop-item-info">
                <span class="label label-success">NEW</span>
                <span class="label label-danger">SALE</span>
            </div>-->
            <!-- /product more info -->
        </div>
        <div class="shop-item-summary text-center">
            <h2><?= $model->name; ?></h2>
            <!-- rating -->
            <!-- /rating -->
            <? if ($shopProduct && $shopProduct->baseProductPrice) : ?>
                <!-- price -->
                <div class="shop-item-price">
                    <? if ($shopProduct->minProductPrice->id == $shopProduct->baseProductPrice->id) : ?>
                        <?= \Yii::$app->money->convertAndFormat($shopProduct->minProductPrice->money); ?>
                    <? else : ?>
                        <span
                            class="line-through"><?= \Yii::$app->money->convertAndFormat($shopProduct->baseProductPrice->money); ?></span>
                        <span
                            class="sx-discount-price"><?= \Yii::$app->money->convertAndFormat($shopProduct->minProductPrice->money); ?></span>
                    <? endif; ?>
                </div>
                <!-- /price -->
            <? endif; ?>
        </div>
        <!--<div class="shop-item-buttons text-center">
            <a class="btn btn-default" href="#" onclick="sx.Shop.addProduct(<? /*= $shopProduct->id; */ ?>, 1); return false;"><i class="fa fa-cart-plus"></i> В корзину</a>
        </div>-->
    </div>
</li>
