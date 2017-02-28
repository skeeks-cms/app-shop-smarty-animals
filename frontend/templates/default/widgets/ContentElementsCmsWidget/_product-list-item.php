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
/*$model->name = $model->name . " ({$model->relatedPropertiesModel->getSmartAttribute('brand')})";*/
?>
<li class="col-lg-12 col-sm-12 col-xs-12">
    <div class="shop-one-item-list row">
        <div class="col-md-9">
            <!-- product image(s) -->
            <div class="pull-left col-md-4" style="text-align: center;">
                <a class="shop-item-image" href="<?= $model->url; ?>" data-pjax="0">
                    <img src="<?= \Yii::$app->settings->imageLoader; ?>" data-original="<?= \skeeks\cms\helpers\Image::getSrc(
                        \Yii::$app->imaging->getImagingUrl($model->image ? $model->image->src : null,
                            new \skeeks\cms\components\imaging\filters\Thumbnail([
                                'w' => 0,
                                'h' => 200,
                            ])
                        )); ?>" title="<?= $model->name; ?>" alt="<?= $model->name; ?>"
                         class="img_list_catalog sx-lazy"/>
                </a>
            </div>
            <div class="pull-left col-md-8">
                <div class="shop-item-summary-list">
                    <h2><a class="shop-item-image" href="<?= $model->url; ?>" data-pjax="0">
                            <?= $model->name; ?>
                        </a></h2>
                    <? if ($brand = $model->relatedPropertiesModel->getSmartAttribute('brand')) : ?>
                        <p>
                            <?
                            $dataQuery = [];
                            $dataQuery['mode'] = 'products';
                            $dataQuery['SearchRelatedPropertiesModel']['brand'] = [$model->relatedPropertiesModel->getAttribute('brand')];
                            $urlBrand = "/catalog?" . http_build_query($dataQuery);
                            ?>
                            Производитель: <a href="<?= $urlBrand; ?>" target="_blank" data-pjax="0"><?= $brand; ?></a>
                        </p>
                    <? endif; ?>
                </div>
            </div>
            <!-- /product image(s) -->
            <!-- hover buttons -->
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
        <div class="col-md-3">
            <div class="shop-item-summary-list" style="text-align: right;">
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

                <div class="sx-to-cart-btn-wrapper" style="margin-top: 10px;">
                    <? if ($shopProduct && $shopProduct->product_type == \skeeks\cms\shop\models\ShopProduct::TYPE_SIMPLE) : ?>
                        <input type="number" id="sx-number-<?= $model->id; ?>" value="1" name="qty" class="form-control pull-left sx-basket-quantity" style="width: 50px;
    border: #ddd 1px solid;
    border-radius: 0px;" maxlength="3" max="999" min="1" data-basket_id="786">
                        <a class="btn btn-default btn-primary product-add-cart noradius" href="#"
                               onclick="sx.Shop.addProduct(<?= $model->id; ?>, $('#sx-number-<?= $model->id; ?>').val()); return false;"><i
                                    class="fa fa-cart-plus"></i> В корзину</a>
                    <? else : ?>
                        <a class="btn btn-default btn-primary product-add-cart noradius" href="<?= $model->url; ?>" data-pjax="0"><i
                                    class="glyphicon glyphicon-eye-open"></i> Выбрать фасовку</a>
                    <? endif; ?>
                </div>
            </div>
        </div>
    </div>
</li>
