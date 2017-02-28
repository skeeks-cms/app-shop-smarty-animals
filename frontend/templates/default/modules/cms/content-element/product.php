<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 24.05.2015
 */
/* @var $this \yii\web\View */
/* @var $model \skeeks\cms\models\CmsContentElement */
\frontend\assets\OwnCarouselAsset::register($this);
\frontend\assets\ZoomAsset::register($this);
\frontend\assets\LightBoxAsset::register($this);
\Yii::$app->cmsToolbar->editUrl = \skeeks\cms\helpers\UrlHelper::construct(['/shop/admin-cms-content-element/update', 'pk' => $model->id])
    ->setSystemParam(\skeeks\cms\modules\admin\Module::SYSTEM_QUERY_EMPTY_LAYOUT, true)
    ->enableAdmin()->toString();
$this->registerJs(<<<JS
$(window).ready(function()
{

    _.delay(function()
    {
        $('.sx-thumbnail .thumbnail:first').click();
    }, 400);
});


$(".sx-fancy").on('click', function()
{
    var href = $(this).attr('href');
    $(".sx-fancybox-gallary[href='" + href + "']").click();
    return false;
});

new sx.classes.OwnCarousel({
	'jsquerySelector' : '.owl-carousel'
});
new sx.classes.Zoom({
	'jsquerySelector' : '.zoom'
});
/*new sx.classes.LightBox({
	'jsquerySelector' : '.lightbox'
});*/


JS
);
$shopCmsContentElement = new \skeeks\cms\shop\models\ShopCmsContentElement($model->toArray());
$shopProduct = \skeeks\cms\shop\models\ShopProduct::getInstanceByContentElement($model);
$product = \common\models\Moto::instance($model);
$shopProduct->createNewView();

?>
<?= $this->render('@template/include/breadcrumbs', [
    'model' => $model
]) ?>
<!-- Product page -->
<section class="padding-xxs">
    <div class="row" itemscope itemtype="http://schema.org/Product">
        <meta itemprop="name" content="<?= \yii\helpers\Html::encode($model->name); ?>" />
        <meta itemprop="image" content="<?= $model->image->absoluteSrc; ?>" />
        <meta itemprop="url" content="<?= $model->absoluteUrl; ?>" />

        <div class="col-md-12">
            <div class="col-lg-9 col-md-9 col-sm-9 col-lg-push-3 col-md-push-3 col-sm-push-3">
                <div class="row">
                    <!-- IMAGE -->
                    <div class="col-lg-6 col-sm-6 sx-product-images">
                        <div class="thumbnail relative margin-bottom-3">
                            <!--
                                IMAGE ZOOM

                                data-mode="mouseover|grab|click|toggle"
                            -->
                            <figure id="zoom-primary" class="zoom" data-mode="mouseover"
                                    style="position: relative; overflow: hidden;">
                                <!--
                                    zoom buttton

                                    positions available:
                                        .bottom-right
                                        .bottom-left
                                        .top-right
                                        .top-left
                                -->
                                <a class="lightbox sx-fancy bottom-right " title="<?= $model->image ? $model->image->name : ''; ?>"
                                   href="<?= $model->image ? \Yii::$app->imaging->thumbnailUrlOnRequest($model->image ? $model->image->src : null,
                                       new \common\thumbnails\MediumWatermark(), $model->code
                                   ) : \skeeks\cms\helpers\Image::getCapSrc(); ?>" data-plugin-options='{"type":"image"}'>
                                    <i class="glyphicon glyphicon-search"></i>
                                </a>
                                <!--
                                    image

                                    Extra: add .image-bw class to force black and white!
                                -->
                                <a class="sx-fancybox-gallary" style="display: none;" data-fancybox-group="gallery"
                                   href="<?= $model->image ? $model->image->src : ''; ?>" title="<?= $model->image ? $model->image->name : ''; ?>"></a>
                                <img src="<?= \Yii::$app->settings->imageLoader; ?>" class="img-responsive sx-lazy"
                                     data-original="<?= $model->image ? $model->image->src : \skeeks\cms\helpers\Image::getCapSrc(); ?>" title="<?= $model->name; ?>"
                                     alt="<?= $model->name; ?>" width="1200">
                            </figure>
                        </div>
                        <?
                        $gallery = [];
                        if ($model->image)
                        {
                            $gallery = [$model->image];
                        }
                        ?>
                        <? if ($model->images) {
                            $gallery = array_merge($gallery, $model->images);
                        }
                        ?>

                        <? if ($gallery) : ?>
                            <!-- Thumbnails (required height:100px) -->
                            <div data-for="zoom-primary"
                                 class="zoom-more owl-carousel owl-padding-3 featured sx-thumbnail"
                                 data-plugin-options='{"singleItem": false, "autoPlay": false, "navigation": true, "pagination": false, "items": 4, "progressBar":"false"}'
                                 style="opacity: 1; display: block;">
                                <? foreach ($gallery as $image) : ?>
                                    <a class="sx-fancybox-gallary" style="display: none;" data-fancybox-group="gallery"
                                       href="<?= $image ? $image->src : ''; ?>" title="<?= $image ? $image->name : ''; ?>"></a>
                                    <a class="thumbnail" href="<?= $image ? $image->src : ''; ?>" title="<?= $image ? $image->name : ''; ?>">
                                        <img src="<?= \Yii::$app->settings->imageLoader; ?>"
                                             data-original="<?= \Yii::$app->imaging->thumbnailUrlOnRequest($image ? $image->src : null,
                                                 new \skeeks\cms\components\imaging\filters\Thumbnail([
                                                     'h' => 100,
                                                     'w' => 0,
                                                 ])
                                             ) ?>" class="sx-lazy" height="100" alt="<?= $image ? $image->name : ''; ?>"
                                             title="<?= $image ? $image->name : ''; ?>" style="min-height: 100px">
                                    </a>
                                <? endforeach; ?>
                            </div>
                            <!-- /Thumbnails -->
                        <? endif; ?>
                    </div>
                    <!-- /IMAGE -->
                    <!-- ITEM DESC -->
                    <div class="col-lg-6 col-sm-6">
                        <? \skeeks\cms\modules\admin\widgets\Pjax::begin(); ?>

                        <?
                        $offer = null;
                        $offerId = \Yii::$app->request->get('sx-offer');
                        if (!$offerId) {
                            if ($shopCmsContentElement->tradeOffers) {
                                $tradeOffers = $shopCmsContentElement->tradeOffers;
                                $offer = array_shift($tradeOffers);
                                $offerId = $offer->id;
                            }
                        }
                        if ($offerId) {
                            /**
                             * @var $offer \skeeks\cms\shop\models\ShopCmsContentElement
                             */
                            $offer = \skeeks\cms\shop\models\ShopCmsContentElement::findOne($offerId);
                        }
                        ?>

                        <?
                        $this->registerJs(<<<JS
    (function(sx, $, _)
    {

        sx.classes.Order = sx.classes.Component.extend({

            _init: function()
            {

            },

            _onDomReady: function()
            {

                var self = this;
                this.jForm = $("form.offers-form");
                $("select", this.jForm).on('change', function()
                {
                    self.jForm.submit();
                });
    /*				$(".sx-add-to-cart").on('click', function()
                {
                    var offer = $("input:checked", self.jForm).val();
                    sx.Shop.addProduct(offer, $('#prod-quantity').val());

                    $('#btnAddToCart').hide();
                    $('#btnInTheBasket').show();
                });*/
            }
        });



        new sx.classes.Order();
    })(sx, sx.$, sx._);
JS
                        )
                        ?>
                        <!-- price -->
                        <div class="shop-item-price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                            <? if ($offer) : ?>
                              <meta itemprop="priceCurrency" content="<?= $offer->shopProduct->baseProductPrice->money->getCurrency()->getCurrencyCode(); ?>" />
                              <meta itemprop="price" content="<?= $offer->shopProduct->baseProductPrice->money->getValue(); ?>" />

                                <? if ($offer->shopProduct->minProductPrice->id == $offer->shopProduct->baseProductPrice->id) : ?>
                                    <?= \Yii::$app->money->convertAndFormat($offer->shopProduct->minProductPrice->money); ?>
                                <? else : ?>
                                    <span
                                        class="line-through nopadding-left"><?= \Yii::$app->money->convertAndFormat($offer->shopProduct->baseProductPrice->money); ?></span>
                                    <div
                                        class="sx-discount-price"><?= \Yii::$app->money->convertAndFormat($offer->shopProduct->minProductPrice->money); ?></div>
                                <? endif; ?>
                            <? else : ?>
                                <meta itemprop="priceCurrency" content="<?= $shopProduct->baseProductPrice->money->getCurrency()->getCurrencyCode(); ?>" />
                              <meta itemprop="price" content="<?= $shopProduct->baseProductPrice->money->getValue(); ?>" />


                                <? if ($shopProduct->minProductPrice->id == $shopProduct->baseProductPrice->id) : ?>
                                    <?= \Yii::$app->money->convertAndFormat($shopProduct->minProductPrice->money); ?>
                                <? else : ?>
                                    <span
                                        class="line-through nopadding-left"><?= \Yii::$app->money->convertAndFormat($shopProduct->baseProductPrice->money); ?></span>
                                    <div
                                        class="sx-discount-price"><?= \Yii::$app->money->convertAndFormat($shopProduct->minProductPrice->money); ?></div>
                                <? endif; ?>
                            <? endif; ?>
                        </div>
                        <!-- /price -->
                        <hr>
                        <div class="clearfix margin-bottom-30">
                            <? if ($model->description_short) : ?>
                            <p><?= $model->description_short; ?></p>
                            <hr/>
                            <? endif; ?>
                            <?
                            $brand = null;
                            $brandId = $model->relatedPropertiesModel->getAttribute('brand');
                            if ($brandId) {
                                $brand = \skeeks\cms\models\CmsContentElement::findOne($brandId);
                            }
                            ?>
                            <? if ($brand && $brand->image) : ?>
                            <span class="pull-right text-danger"><img src="<?= $brand->image->src ?>"
                                                                      style="max-height: 80px; max-width: 180px;"></span>
                            <? endif; ?>
                            <!--
                            <span class="pull-right text-danger"><i class="glyphicon glyphicon-remove"></i> Out of Stock</span>
                            -->

                            <? $widget = \skeeks\cms\rpViewWidget\RpViewWidget::beginWidget('product-properties', [
                                'model' => $model,
                                //'visible_properties' => ['color', 'material'],
                                //'visible_only_has_values' => true,
                                //'viewFile' => '@app/views/your-file',
                            ]); ?>
                                <?/* $widget->viewFile = '@app/views/modules/cms/content-element/_product-properties';*/?>
                            <? \skeeks\cms\rpViewWidget\RpViewWidget::end(); ?>




                            <? if ($propPaint = $model->relatedPropertiesModel->getAttribute('propPaint')) : ?>
                            <div class="icons-group">
                                <ul class="icons-list flat cf">

                                <?
                                $enums = $model->relatedPropertiesModel->getRelatedProperty('propPaint')->getEnums()->andWhere([
                                    'id' => $propPaint
                                ])->all();
                                /**
                                 * @var \skeeks\cms\models\CmsContentPropertyEnum $enum
                                 */
                                ?>

                                <? foreach($enums as $enum) : ?>
                                    <li class="hint-owner baza-p" style="background-image: url(<?= \frontend\assets\AppAsset::getAssetUrl('img/icons/' . $enum->code . '.png')?>);"
                                        title="<?= $enum->value; ?>" data-toggle="tooltip">
                                        <div class="hint bottom left">
                                            <!--<p><?/*= $enum->value; */?></p>-->
                                        </div>
                                    </li>

                                <? endforeach; ?>
                                </ul>
                            </div>
                            <? endif; ?>


                        </div>
                        <hr>
                        <? if ($shopCmsContentElement->shopProduct->product_type == \skeeks\cms\shop\models\ShopProduct::TYPE_OFFERS) : ?>
                            <form class="offers-form form" data-pjax>
                                <label>Фасовка и цвет: </label>
                                <?
                                $selectData = [];
                                foreach ($shopCmsContentElement->tradeOffers as $offerChild) {
                                    if ($offerChild->shopProduct->quantity > 0) {
                                        $color = trim($offerChild->relatedPropertiesModel->getSmartAttribute('color'));
                                        $selectData[$offerChild->id] = $offerChild->relatedPropertiesModel->getSmartAttribute('packing') . " " . $offerChild->relatedPropertiesModel->getSmartAttribute('measure') . ($color ? " - " . $color : "");
                                    }
                                }
                                ?>



                                <? if ($selectData) : ?>
                                    <?= \yii\helpers\Html::listBox('sx-offer', $offer->shopProduct->id, $selectData, [
                                        'size' => 1,
                                        'id' => 'sx-offer'
                                    ]); ?>
                                    <a class="btn btn-default btn-primary product-add-cart noradius" href="#"
                                       onclick="sx.Shop.addProduct($('#sx-offer').val(), 1); return false;"><i
                                            class="fa fa-cart-plus"></i> В корзину</a>
                                    <br/>
                                    <!--<p><a href="/size" target="_blank" data-pjax="0">Как выбрать размер?</a></p>-->
                                    <br/>
                                <? else: ?>
                                    <p style="color:red;">Товара нет в наличии</p>
                                <? endif; ?>
                            </form>
                        <? else : ?>
                            <a class="btn btn-default btn-primary btn-lg product-add-cart noradius" href="#"
                               onclick="sx.Shop.addProduct(<?= $model->id; ?>, 1); return false;"><i
                                    class="fa fa-cart-plus"></i> В корзину</a><br/><br/>
                        <? endif; ?>
                        <!--<hr>

                        <div class="">

                            <? /*=
                                \kartik\rating\StarRating::widget(\yii\helpers\ArrayHelper::merge([
                                        'name' => 'rating_1',
                                        'value' => (float) $model->relatedPropertiesModel->getAttribute('reviews2_rating'),
                                        'pluginOptions' => [
                                            'disabled'  => true,
                                            'showClear' => false,
                                            'size'      => 'sm',
                                            'clearCaption' => (int) $model->relatedPropertiesModel->getAttribute('reviews2_count') . ' отзывов',
                                            'starCaptions' =>
                                            [
                                                1 => 'Отзывов: ' . (int) $model->relatedPropertiesModel->getAttribute('reviews2_count'),
                                                2 => 'Отзывов: ' . (int) $model->relatedPropertiesModel->getAttribute('reviews2_count'),
                                                3 => 'Отзывов: ' . (int) $model->relatedPropertiesModel->getAttribute('reviews2_count'),
                                                4 => 'Отзывов: ' . (int) $model->relatedPropertiesModel->getAttribute('reviews2_count'),
                                                5 => 'Отзывов: ' . (int) $model->relatedPropertiesModel->getAttribute('reviews2_count'),
                                            ]
                                        ]
                                    ], (array) $options));
                            */ ?>
                        </div>-->
                        <hr>
                        <!-- Share -->
                        <div class="pull-right">
                            <?
                            if ($model->image) {
                                $this->registerMetaTag([
                                    'property' => 'og:image',
                                    'content' => $model->image->src
                                ]);
                            }
                            if ($model->description_full) {
                                $this->registerMetaTag([
                                    'property' => 'og:description',
                                    'content' => $model->description_full
                                ]);
                            }
                            $this->registerMetaTag([
                                'property' => 'og:title',
                                'content' => $model->name
                            ]);
                            ?>

                            <?= \skeeks\cms\yandex\share\widget\YaShareWidget::widget([
                                'namespace' => 'YaShareWidget-main'
                            ]); ?>
                        </div>
                        <!-- /Share -->
                        <? \skeeks\cms\modules\admin\widgets\Pjax::end(); ?>
                    </div>
                    <!-- /ITEM DESC -->
                </div>


                <ul id="myTab" class="nav nav-tabs nav-top-border" role="tablist">
                    <li role="presentation" class="active"><a href="#description" role="tab"
                                                              data-toggle="tab">Описание</a></li>
                    <li role="presentation"><a href="#sx-reviews" role="tab" data-toggle="tab">Отзывы
                            (<?= $product->reviewsCount ?>)</a></li>

                    <!--<li role="presentation"><a href="#sx-vk" role="tab" data-toggle="tab">Обсуждение</a></li>-->
                    <!--<li role="presentation"><a href="#sx-feedback" role="tab" data-toggle="tab">Обратная связь</a></li>
                -->
                </ul>

                <div class="tab-content padding-top-20">
                    <!-- DESCRIPTION -->
                    <div role="tabpanel" class="tab-pane fade in active" id="description">
                        <div style="padding-left: 10px;">
                            <?= $model->description_full; ?>
                            <? if ($model->description_full) : ?>
                            <? endif; ?>
                            <? if ($extra = $model->relatedPropertiesModel->getAttribute('extra')) : ?>
                                <table class="prod-char">
                                    <? $counter = 0; ?>
                                    <? foreach($extra as $row) : ?>
                                        <? $counter ++; ?>
                                        <tr class="<?= $counter % 2 == 0 ? "even-tr" : ""?>">
                                            <td><?= \yii\helpers\ArrayHelper::getValue($row, 'name'); ?></td>
                                            <td class="rtd"><?= \yii\helpers\ArrayHelper::getValue($row, 'value'); ?></td>
                                        </tr>
                                    <? endforeach; ?>
                                </table>
                            <? endif; ?>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="sx-vk">
                        <?= \skeeks\cms\vk\comments\VkCommentsWidget::widget([
                            'namespace' => 'VkCommentsWidget-main',
                            'apiId'     => 5705491
                        ]); ?>
                    </div>

                    <!-- SPECIFICATIONS -->
                    <div role="tabpanel" class="tab-pane fade" id="sx-reviews">
                        <?= \skeeks\cms\reviews2\widgets\reviews2\Reviews2Widget::widget([
                            'namespace' => 'Reviews2Widget',
                            'viewFile' => '@app/views/widgets/Reviews2Widget/package',
                            'cmsContentElement' => $model
                        ]); ?>
                    </div>
                    <!--<div role="tabpanel" class="tab-pane fade" id="sx-feedback">
                        <?/*=
                        \skeeks\modules\cms\form2\cmsWidgets\form2\FormWidget::widget([
                            'form_code' => 'credit'
                        ]);
                        */?>
                    </div>-->
                </div>


                <? if ($simmilarIds = $model->relatedPropertiesModel->getAttribute('simillar')) : ?>
                    <div style="margin-bottom: 20px;">
                    <?= \skeeks\cms\cmsWidgets\contentElements\ContentElementsCmsWidget::widget([
                        'contentElementClass' => \skeeks\cms\shop\models\ShopCmsContentElement::className(),
                        'namespace' => 'ContentElementsCmsWidget-need',
                        'viewFile' => '@app/views/widgets/ContentElementsCmsWidget/sameProducts',
                        'label' => 'Вам могут понадобиться',
                        'enabledCurrentTree' => "N",
                        'limit' => 10,
                        'activeQueryCallback' => function (\yii\db\ActiveQuery $query) use ($model, $simmilarIds) {

                            $query->andWhere([
                                'id' => $simmilarIds
                            ]);

                            $query->with('shopProduct');
                            $query->with('shopProduct.baseProductPrice');
                            $query->with('shopProduct.minProductPrice');
                            //$query->with('shopProduct.baseProductPrice');
                        }
                    ]); ?>
                    </div>
                <? endif; ?>



                <?
                $treeIds = [];
                if ($model->cmsTree && $model->cmsTree->parent)
                {
                    $treeIds = \yii\helpers\ArrayHelper::map($model->cmsTree->parent->children, 'id', 'id');
                }
                ?>
                <?= \skeeks\cms\cmsWidgets\contentElements\ContentElementsCmsWidget::widget([
                    'contentElementClass' => \skeeks\cms\shop\models\ShopCmsContentElement::className(),
                    'namespace' => 'ContentElementsCmsWidget-sameProducts',
                    'viewFile' => '@app/views/widgets/ContentElementsCmsWidget/sameProducts',
                    'label' => 'Похожие товары',
                    'enabledCurrentTree' => "N",
                    'tree_ids' => $treeIds,
                    'limit' => 10,
                    'activeQueryCallback' => function (\yii\db\ActiveQuery $query) use ($model, $shopProduct) {

                        $value = $shopProduct->minProductPrice->money->getValue();
                        $query->leftJoin('shop_product sp', 'sp.id = cms_content_element.id');
                        $query->leftJoin('shop_product_price price', 'price.product_id = sp.id');

                        $query->andWhere([
                            'content_id' => $model->content_id
                        ]);

                        $query->andWhere([
                            'type_price_id' => 4
                        ]);

                        $query->andWhere([
                            'and',
                            ['<', 'price', (float) $value + 1000],
                            ['>', 'price', (float) $value - 1000],
                        ]);

                        $query->andWhere(['!=', \skeeks\cms\models\CmsContentElement::tableName() . ".id", $model->id]);

                        $query->with('shopProduct');
                        $query->with('shopProduct.baseProductPrice');
                        $query->with('shopProduct.minProductPrice');
                        //$query->with('shopProduct.baseProductPrice');
                    }
                ]); ?>

            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-lg-pull-9 col-md-pull-9 col-sm-pull-9 sx-left-column">
                <!-- CATEGORIES -->
                <div class="side-nav margin-bottom-20 margin-top-10">
                    <?= \common\widgets\LeftMenu::widget([
                        'tree' => $model->cmsTree
                    ]); ?>
                </div>

                <?= \skeeks\cms\cmsWidgets\contentElements\ContentElementsCmsWidget::widget([
                    'namespace' => 'ContentElementsCmsWidget-VisitedProducts',
                    'viewFile' 	=> '@app/views/widgets/ContentElementsCmsWidget/visitedProducts',
                    'label' 	=> 'Вы посмотрели',
                    'limit' 	=> 6,
                    'activeQueryCallback' 	=> function(\yii\db\ActiveQuery $query) use ($model)
                    {
                        $query->andWhere(['!=', \skeeks\cms\models\CmsContentElement::tableName() . ".id", $model->id]);
                        $query->leftJoin('shop_product', '`shop_product`.`id` = `cms_content_element`.`id`');
                        $query->leftJoin('shop_viewed_product', '`shop_viewed_product`.`shop_product_id` = `shop_product`.`id`');

                        $query->andWhere(['shop_fuser_id' => \Yii::$app->shop->shopFuser->id]);
                        //$query->orderBy(['shop_viewed_product.created_at' => SORT_DESC]);
                    }
                ]); ?>

                <?= \skeeks\cms\cmsWidgets\contentElements\ContentElementsCmsWidget::widget([
                    'contentElementClass' => \skeeks\cms\shop\models\ShopCmsContentElement::className(),
                    'namespace'         => 'ContentElementsCmsWidget-catalog-main-left-1',
                    'viewFile' 	        => '@app/views/widgets/ContentElementsCmsWidget/visitedProducts',
                    'label'             => 'Спецпредложения',
                    'pageSize'          => 5,
                    'enabledCurrentTree'=> \skeeks\cms\components\Cms::BOOL_N,
                    'dataProviderCallback' 	=> function(\yii\data\ActiveDataProvider $activeDataProvider) use ($model) {
                        $query = $activeDataProvider->query;

                        $query->with('shopProduct');
                        $query->with('shopProduct.baseProductPrice');
                        $query->with('shopProduct.minProductPrice');
                    }
                ]); ?>
                <!--<div class="side-nav margin-bottom-20">

                <p></p>
            </div>-->
                <!--<div class="side-nav margin-bottom-20">

                <h2 class="owl-featured">Мы в социальных сетях</h2>

                <? /*= \skeeks\cms\vk\community\VkCommunityWidget::widget([
                    'namespace' => 'VkCommunityWidget-moto',
                    'apiId'     => 72101610
                ]); */ ?>

                <p></p>

            </div>-->
            </div>
        </div>
    </div>
</section>



