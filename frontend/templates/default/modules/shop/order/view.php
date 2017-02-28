<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 06.10.2015
 */

/* @var $this yii\web\View */
/* @var $model \skeeks\cms\shop\models\ShopOrder */
use yii\helpers\Html;
?>

<?= \Yii::$app->view->render('@app/views/modules/cms/user/_header', [
    'model'     => \Yii::$app->user->identity,
    'title'     => 'Мои заказы',
]); ?>
<div class="box-light">
<!--=== Content Part ===-->
        <div class ="row">
            <div class="col-lg-12 col-md-10">
                <h4>Заказ №<?= $model->id; ?> от <?= \Yii::$app->formatter->asDatetime($model->created_at); ?> </h4>


                <div class="table-responsive">
                    <?= \yii\widgets\DetailView::widget([
                        'model' => $model,
                        'template'   => "<tr><th>{label}</th><td style='width:50%;'>{value}</td></tr>",
                        'attributes' => [
                            [                      // the owner name of the model
                                'label'     => 'Номер заказа',
                                'format'    => 'raw',
                                'value'     => $model->id,
                            ],
                            [                      // the owner name of the model
                                'label'     => 'Создан',
                                'format'    => 'raw',
                                'value'     => \Yii::$app->formatter->asDatetime($model->created_at),
                            ],
                            [                      // the owner name of the model
                                'label'     => 'Сумма заказа',
                                'format'    => 'raw',
                                'value'     => \Yii::$app->money->convertAndFormat($model->moneyOriginal),
                            ],
                            [                      // the owner name of the model
                                'label'     => 'Способ оплаты',
                                'format'    => 'raw',
                                'value'     => $model->paySystem->name,
                            ],
                            [
                                'label'     => 'Доставка',
                                'format'    => 'raw',
                                'value'     => 'Курьер',
                            ],
                            [                      // the owner name of the model
                                'label'     => 'Статус',
                                'format'    => 'raw',
                                'value'     => Html::tag('span', $model->status->name, ['style' => 'color: '.$model->status->color]),
                            ],
                            [                      // the owner name of the model
                                'attribute'     => 'Заказ отменен',
                                'label'     => 'Заказ отменен',
                                'format'    => 'raw',
                                'value'     => $model->reason_canceled,
                                'visible'   => $model->canceled == 'Y',
                            ],
                        ]
                    ])?>


                </div>

                <h4>Данные учетной записи: </h4>
                <div class="table-responsive">
                        <?= \yii\widgets\DetailView::widget([
                            'model' => $model->buyer->relatedPropertiesModel,
                            'template'   => "<tr><th style='width: 50%; '>{label}</th><td style='width:50%;'>{value}</td></tr>",
                            'attributes' => array_keys($model->buyer->relatedPropertiesModel->toArray())

                        ])?>
                </div>
                <h4>Содержимое заказа: </h4>
                <!-- cart content -->
                <div id="cartContent" class="cartContent clearfix">
                    <!-- cart header -->
                    <div class="item head clearfix">
                        <span class="cart_img"></span>
                        <span class="product_name size-13 bold">Товар</span>
                        <span class="remove_item size-13 bold"></span>
                        <span class="total_price size-13 bold">Всего</span>
                        <span class="qty size-13 bold">Количество</span>
                    </div>
                    <!-- /cart header -->

                    <? foreach($model->shopBaskets as $shopBasket) : ?>
                        <!-- cart item -->
                        <div class="item">
                            <div class="cart_img pull-left width-100 padding-10 text-left">
                                <img src="<?= \skeeks\cms\helpers\Image::getSrc($shopBasket->image ? $shopBasket->image->src : null); ?>"  alt="<?=$shopBasket->product->cmsContentElement->name;?> title="<?=$shopBasket->product->cmsContentElement->name;?> width="80" />
                            </div>
                            <a href="<?= $shopBasket->product->cmsContentElement->url; ?>" class="product_name" data-pjax="0">
                                <span><?= $shopBasket->product->cmsContentElement->name; ?></span>
                                <!--<small>Color: Brown, Size: XL</small>-->
                            </a>
                            <div class="total_price"><span><?= \Yii::$app->money->convertAndFormat($shopBasket->money); ?></span></div>
                            <div class="qty">
                                <span><?= round($shopBasket->quantity); ?></span>
                                &times;
                                <? if ($shopBasket->moneyOriginal->getAmount() == $shopBasket->money->getAmount()) : ?>
                                    <?= \Yii::$app->money->convertAndFormat($shopBasket->moneyOriginal); ?>
                                <? else : ?>
                                    <span class="line-through nopadding-left"><?= \Yii::$app->money->convertAndFormat($shopBasket->moneyOriginal); ?></span>
                                    <?= \Yii::$app->money->convertAndFormat($shopBasket->money); ?>
                                <? endif; ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <!-- /cart item -->
                    <? endforeach;?>


                    <div class="clearfix"></div>
                </div>
                <!-- /cart content -->

                <div class="toggle-transparent toggle-bordered-full clearfix">
                    <div class="toggle active" style="display: block;">
                        <div class="toggle-content" style="display: block;">

                            <span class="clearfix">
                                <span class="pull-right"><?= \Yii::$app->money->convertAndFormat($model->moneyOriginal); ?></span>
                                <strong class="pull-left">Товаров:</strong>
                            </span>
                                            <? if ($model->moneyDiscount->getValue() > 0) : ?>
                                                <span class="clearfix">
                                    <span class="pull-right"><?= \Yii::$app->money->convertAndFormat($model->moneyDiscount); ?></span>
                                    <span class="pull-left">Скидка:</span>
                                </span>
                                            <? endif; ?>

                                            <? if ($model->moneyDelivery->getValue() > 0) : ?>
                                                <span class="clearfix">
                                    <span class="pull-right"><?= \Yii::$app->money->convertAndFormat($model->moneyDelivery); ?></span>
                                    <span class="pull-left">Доставка:</span>
                                </span>
                                            <? endif; ?>

                                            <? if ($model->moneyVat->getValue() > 0) : ?>
                                                <span class="clearfix">
                                    <span class="pull-right"><?= \Yii::$app->money->convertAndFormat($model->moneyVat); ?></span>
                                    <span class="pull-left">Налог:</span>
                                </span>
                                            <? endif; ?>

                                            <? if ($model->weight > 0) : ?>
                                                <span class="clearfix">
                                    <span class="pull-right"><?= $model->weight; ?> г.</span>
                                    <span class="pull-left">Вес:</span>
                                </span>
                                            <? endif; ?>

                                            <hr />

                            <span class="clearfix">
                                <span class="pull-right size-20"><?= \Yii::$app->money->convertAndFormat($model->money); ?></span>
                                <strong class="pull-left">ИТОГ:</strong>
                            </span>

                            <hr />
                            <? if ($model->allow_payment == \skeeks\cms\components\Cms::BOOL_Y) : ?>
                                <? if ($model->paySystem->paySystemHandler) : ?>
                                    <?= Html::a("Оплатить", \yii\helpers\Url::to(['/shop/order/pay', 'id' => $model->id]), [
                                        'class' => 'btn btn-lg btn-primary'
                                    ]); ?>
                                <? endif; ?>
                            <? else : ?>
                                <? if ($model->paySystem->paySystemHandler) : ?>
                                    В настоящий момент, заказ находится в стадии проверки и сборки. Его можно будет оплатить позже.
                                <? endif; ?>
                            <? endif; ?>

                        </div>
                    </div>
                </div>

            </div>

        </div>

</div>
<?= \Yii::$app->view->render('@app/views/modules/cms/user/_footer'); ?>
