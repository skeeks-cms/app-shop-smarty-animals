<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 22.09.2015
 */
/* @var $this yii\web\View */

if (!\Yii::$app->shop->shopFuser->buyer)
{
    \Yii::$app->response->redirect(\yii\helpers\Url::to(['/shop/cart/checkout']));
}
?>

<?= $this->render('@template/include/breadcrumbs', [
    'title' => 'Выбор способа оплаты'
]) ?>

<?
\frontend\assets\CartAsset::register($this);
\skeeks\cms\shop\widgets\ShopGlobalWidget::widget();

$this->registerJs(<<<JS
    (function(sx, $, _)
    {
        new sx.classes.shop.FullCart(sx.Shop, 'sx-cart-full');
    })(sx, sx.$, sx._);
JS
);
?>


<!--=== Content Part ===-->
<section>
    <div class="container">

        <? \skeeks\cms\modules\admin\widgets\Pjax::begin([
            'id'                    => 'sx-cart-full',
        ]) ?>


        <? if (\Yii::$app->shop->shopFuser->isEmpty()) : ?>
            <!-- EMPTY CART -->
                <div class="panel panel-default">
                <div class="panel-body">
                    <strong>Ваша корзина пуста!</strong><br />
                    В вашей корзине нет покупок.<br />
                    Кликните <a href="/" data-pjax="0">сюда</a> для продолжения покупок. <br />
                    <!--<span class="label label-warning">this is just an empty cart example</span>-->
                </div>
            </div>
            <!-- /EMPTY CART -->
        <? else: ?>

            <ul class="process-steps nav nav-justified">
                <li class="active">
                    <a href="<?= \yii\helpers\Url::to(['/shop/cart']); ?>"  data-pjax="0">1</a>
                    <h5>Корзина</h5>
                </li>
                <li class="active">
                    <a href="<?= \yii\helpers\Url::to(['/shop/cart/checkout']); ?>"  data-pjax="0">2</a>
                    <h5>Оформление</h5>
                </li>
                <li class="active">
                    <a href="<?= \yii\helpers\Url::to(['/shop/cart/payment']); ?>"  data-pjax="0">3</a>
                    <h5>Оплата</h5>
                </li>
                <li>
                    <a href="#">4</a>
                    <h5>Финиш</h5>
                </li>

            </ul>

            <hr />

            <!-- LEFT -->
            <div class="col-lg-9 col-sm-8">

                <!-- CART -->

                <!-- cart content -->
                <div id="cartContent">



                            <? $form = \skeeks\cms\base\widgets\ActiveFormAjaxSubmit::begin([
                                'action' => \yii\helpers\Url::to(['/shop/cart/create-order']),
                                'enableAjaxValidation' => false,
                                'id' => 'shop-create-order',
                                'afterValidateCallback' => new \yii\web\JsExpression(<<<JS
    function(Jform, AjaxQuery)
    {
        new sx.classes.AjaxHandlerStandartRespose(AjaxQuery);
        //AjaxQuery.bind('')
    }
JS
)
                            ]); ?>

                                <?= $form->field(\Yii::$app->shop->shopFuser, 'pay_system_id')->widget(
                                    \skeeks\widget\chosen\Chosen::className(),
                                    [
                                        'items' => \yii\helpers\ArrayHelper::map(\Yii::$app->shop->shopFuser->paySystems, 'id', 'name'),
                                        'placeholder'   => 'Способ оплаты',
                                        'allowDeselect' => false,
                                    ]
                                ); ?>

                                <button class="btn btn-primary">Отправить</button>


                            <? \skeeks\cms\base\widgets\ActiveFormAjaxSubmit::end(); ?>


                    <div class="clearfix"></div>
                </div>
                <!-- /cart content -->

                <!-- /CART -->

            </div>


            <!-- RIGHT -->
            <div class="col-lg-3 col-sm-4">

                <? $url = \yii\helpers\Url::to(['/shop/cart/checkout']) ; ?>
                <?= $this->render("_result", [
                    'submit' => <<<HTML
<a href="{$url}" class="btn btn-primary btn-lg btn-block size-15" data-pjax="0" onclick="new sx.classes.CreateOrder(); return false;">
    <i class="fa fa-mail-forward"></i> Оформить
</a>
HTML

                ]); ?>

                <?
$this->registerJs(<<<JS
sx.classes.CreateOrder = sx.classes.Component.extend({
    _onDomReady: function()
    {
        $('#shop-create-order').submit();
    }
});
JS
)
?>

            </div>
        <? endif; ?>

        <? \skeeks\cms\modules\admin\widgets\Pjax::end() ?>


    </div>
</section>