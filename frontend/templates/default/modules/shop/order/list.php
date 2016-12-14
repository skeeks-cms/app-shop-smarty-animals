<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 06.10.2015
 */

/* @var $this yii\web\View */
/* @var $model \skeeks\cms\shop\models\ShopOrder */
\skeeks\cms\shop\widgets\ShopGlobalWidget::widget();
use yii\helpers\Html;

?>

<?= \Yii::$app->view->render('@app/views/modules/cms/user/_header', [
    'model'     => \Yii::$app->user->identity,
    'title'     => 'Мои заказы',
]); ?>
<div class="box-light">
<!--=== Content Part ===-->

    <?= \yii\grid\GridView::widget([
        'dataProvider' => new \yii\data\ActiveDataProvider([
            'query' => \skeeks\cms\shop\models\ShopOrder::find()->where(['user_id' => \Yii::$app->user->identity->id])->orderBy(['id' =>  'DESC']),
            'sort'  =>  array(
                'defaultOrder' => [
                    'id' =>  SORT_DESC
                    ]
            ),
        ]),
        "columns"               => [
            'id',

            [
                'class'     => \yii\grid\DataColumn::className(),
                'attribute'     => 'status_code',
                'format'     => 'raw',
                'filter'     => \yii\helpers\ArrayHelper::map(\skeeks\cms\shop\models\ShopOrderStatus::find()->all(), 'code', 'name'),
                'value'     => function(\skeeks\cms\shop\models\ShopOrder $order)
                {
                    return \yii\helpers\Html::label($order->status->name, null, [
                        'style' => "background: {$order->status->color}",
                        'class' => "label"
                    ]) . "<br />" .
                        \yii\helpers\Html::tag("small", \Yii::$app->formatter->asDatetime($order->status_at) . " (" . \Yii::$app->formatter->asRelativeTime($order->status_at) . ")")
                    ;
                }
            ],

            [
                'class'         => \skeeks\cms\grid\BooleanColumn::className(),
                'attribute'     => 'payed',
                'format'        => 'raw',
                'label'         => 'Оплата',
                'options'       => array('style'=>'text-align: center;'),

            ],

            /*[
                'class'         => \yii\grid\DataColumn::className(),
                'filter'        => false,
                'format'        => 'raw',
                'label'         => 'Товар',
                'value'         => function(\skeeks\cms\shop\models\ShopOrder $model)
                {
                    if ($model->shopBaskets)
                    {
                        $result = [];
                        foreach ($model->shopBaskets as $shopBasket)
                        {
                            $money = \Yii::$app->money->intlFormatter()->format($shopBasket->money);
                            $result[] = \yii\helpers\Html::a($shopBasket->name, $shopBasket->product->cmsContentElement->url, ['target' => '_blank']) . <<<HTML
— $shopBasket->quantity $shopBasket->measure_name
HTML;

                        }
                        return implode('<hr />', $result);
                    }
                },
            ],*/

            [
                'class'         => \yii\grid\DataColumn::className(),
                'format'        => 'raw',
                'attribute'     => 'price',
                'label'         => 'Сумма',
                'value'         => function(\skeeks\cms\shop\models\ShopOrder $model)
                {
                    return \Yii::$app->money->intlFormatter()->format($model->money);
                },
            ],

            [
                'class'     => \skeeks\cms\grid\CreatedAtColumn::className(),
            ],
            [
                'class'     => \yii\grid\DataColumn::className(),
                'format'        => 'raw',
                'value'         => function(\skeeks\cms\shop\models\ShopOrder $model)
                {
                    return \yii\helpers\Html::a('Подробнее...', \yii\helpers\Url::to(['/shop/order/view', 'id' => $model->id]), ['class' => 'btn btn-default btn-primary product-add-cart noradius']);
                },
                'options'       =>  array('style'=>'text-align: center;')
            ],

        ],

    ]); ?>
</div>

<?= \Yii::$app->view->render('@app/views/modules/cms/user/_footer'); ?>
