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



<!-- Product page -->
<!--=== Content Part ===-->
<section>
    <div class="row">
        <div class="col-sm-12">

<?= \skeeks\cms\shopCartStepsWidget\ShopCartStepsWidget::widget(); ?>
<hr />
<div class="box-light">
    <!--=== Content Part ===-->
    <div class="row">
        <div class="col-lg-12 col-md-10">
            <h4>Заказ №<?= $model->id; ?> от <?= \Yii::$app->formatter->asDatetime($model->created_at); ?> </h4>

            <div class="table-responsive">
                <?= \yii\widgets\DetailView::widget([
                    'model' => $model,
                    'template' => "<tr><th>{label}</th><td style='width:50%;'>{value}</td></tr>",
                    'attributes' => [
                        /*[                      // the owner name of the model
                            'label' => 'Номер заказа',
                            'format' => 'raw',
                            'value' => $model->id,
                        ],*/
                        /*[                      // the owner name of the model
                            'label' => 'Создан',
                            'format' => 'raw',
                            'value' => \Yii::$app->formatter->asDatetime($model->created_at),
                        ],*/
                        [                      // the owner name of the model
                            'label' => 'Сумма заказа',
                            'format' => 'raw',
                            'value' => \Yii::$app->money->convertAndFormat($model->moneyOriginal),
                        ],
                        [                      // the owner name of the model
                            'label' => 'Способ оплаты',
                            'format' => 'raw',
                            'value' => $model->paySystem->name,
                        ],
                        [
                            'label' => 'Доставка',
                            'format' => 'raw',
                            'value' => 'Курьер',
                        ],
                        [                      // the owner name of the model
                            'label' => 'Статус',
                            'format' => 'raw',
                            'value' => Html::tag('span', $model->status->name, ['style' => 'color: ' . $model->status->color]),
                        ],
                        [                      // the owner name of the model
                            'label' => 'Оплата',
                            'format' => 'raw',
                            'value' => $model->payed == 'Y' ? "<span style='color: green;'>Оплачен</span>" : "<span style='color: red;'>Не оплчаен</span>",
                        ],
                        [                      // the owner name of the model
                            'attribute' => 'Заказ отменен',
                            'label' => 'Заказ отменен',
                            'format' => 'raw',
                            'value' => $model->reason_canceled,
                            'visible' => $model->canceled == 'Y',
                        ],
                    ]
                ]) ?>
            </div>
            <h4>Данные покупателя: </h4>

            <div class="table-responsive">
                <?= \yii\widgets\DetailView::widget([
                    'model' => $model->buyer->relatedPropertiesModel,
                    'template' => "<tr><th style='width: 50%; '>{label}</th><td style='width:50%;'>{value}</td></tr>",
                    'attributes' => array_keys($model->buyer->relatedPropertiesModel->toArray())
                ]) ?>
            </div>
            <h4>Содержимое заказа: </h4>
            <!-- cart content -->
            <?= \skeeks\cms\shopCartItemsWidget\ShopCartItemsListWidget::widget([
                'dataProvider' => new \yii\data\ActiveDataProvider([
                    'query' => $model->getShopBaskets(),
                    'pagination' =>
                    [
                        'defaultPageSize' => 100,
                        'pageSizeLimit' => [1, 100],
                    ],
                ]),
                'footerView'    => false,
                'itemView'      => '@skeeks/cms/shopCartItemsWidget/views/items-list-order-item',
            ]); ?>
            <!-- /cart content -->
            <div class="toggle-transparent toggle-bordered-full clearfix">
                <div class="toggle active" style="display: block;">
                    <div class="toggle-content" style="display: block;">

                            <span class="clearfix">
                                <span
                                    class="pull-right"><?= \Yii::$app->money->convertAndFormat($model->moneyOriginal); ?></span>
                                <strong class="pull-left">Товаров:</strong>
                            </span>
                        <? if ($model->moneyDiscount->getValue() > 0) : ?>
                            <span class="clearfix">
                                    <span
                                        class="pull-right"><?= \Yii::$app->money->convertAndFormat($model->moneyDiscount); ?></span>
                                    <span class="pull-left">Скидка:</span>
                                </span>
                        <? endif; ?>

                        <? if ($model->moneyDelivery->getValue() > 0) : ?>
                            <span class="clearfix">
                                    <span
                                        class="pull-right"><?= \Yii::$app->money->convertAndFormat($model->moneyDelivery); ?></span>
                                    <span class="pull-left">Доставка:</span>
                                </span>
                        <? endif; ?>

                        <? if ($model->moneyVat->getValue() > 0) : ?>
                            <span class="clearfix">
                                    <span
                                        class="pull-right"><?= \Yii::$app->money->convertAndFormat($model->moneyVat); ?></span>
                                    <span class="pull-left">Налог:</span>
                                </span>
                        <? endif; ?>

                        <? if ($model->weight > 0) : ?>
                            <span class="clearfix">
                                    <span class="pull-right"><?= $model->weight; ?> г.</span>
                                    <span class="pull-left">Вес:</span>
                                </span>
                        <? endif; ?>
                        <hr/>

                            <span class="clearfix">
                                <span
                                    class="pull-right size-20"><?= \Yii::$app->money->convertAndFormat($model->money); ?></span>
                                <strong class="pull-left">ИТОГ:</strong>
                            </span>
                        <hr/>
                        <? if ($model->allow_payment == \skeeks\cms\components\Cms::BOOL_Y) : ?>
                            <? if ($model->paySystem->paySystemHandler && $model->payed == 'N') : ?>
                                <?= Html::a("Оплатить", \yii\helpers\Url::to(['/shop/order/finish-pay', 'key' => $model->key]), [
                                    'class' => 'btn btn-lg btn-primary'
                                ]); ?>
                            <? else : ?>

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



    </div>
</div>
</section>
<?

$this->registerCss(<<<CSS
ul.process-steps li.active a, ul.process-steps li.active:hover>a {
    background-color: #3fb5d6;
}
CSS
);
?>