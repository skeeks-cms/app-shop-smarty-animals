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
$shopProduct = \skeeks\cms\shop\models\ShopProduct::getInstanceByContentElement($model);
?>
<!-- item -->
<div class="shop-item nomargin">
    <div class="thumbnail">
        <!-- product image(s) -->
        <a class="shop-item-image" href="<?= $model->url; ?>">
            <img src="<?= \Yii::$app->settings->imageLoader; ?>" class="sx-lazy"
                 data-original="<?= \skeeks\cms\helpers\Image::getSrc(\Yii::$app->imaging->getImagingUrl($model->image ? $model->image->src : null,
                     new \skeeks\cms\components\imaging\filters\Thumbnail([
                         'w' => 0,
                         'h' => 200,
                     ])
                 )); ?>" alt="<?= $model->name; ?>" title="<?= $model->name; ?>"/>
            <!--img class="img-responsive" src="assets/images/demo/shop/products/300x450/p14.jpg" alt="shop hover image" /-->
        </a>
        <!-- /product image(s) -->
    </div>
    <div class="shop-item-summary text-center">
        <h2><?= $model->name; ?></h2>
        <!-- price -->
        <div class="shop-item-price">
            <!--span class="line-through">$98.00</span-->
            <? if ($shopProduct) : ?>
                <?= \Yii::$app->money->convertAndFormat($shopProduct->baseProductPrice->money); ?>
            <? endif; ?>
        </div>
        <!-- /price -->
    </div>
    <!-- buttons -->
    <!--<div class="shop-item-buttons text-center">
            <a class="btn btn-default btn-sm" href="#" onclick="sx.Shop.addProduct(<? /*= $model->id; */ ?>, 1); return false;"><i class="fa fa-cart-plus"></i> Добавить в корзину</a>
        </div>-->
    <!-- /buttons -->
</div>
<!-- /item -->
