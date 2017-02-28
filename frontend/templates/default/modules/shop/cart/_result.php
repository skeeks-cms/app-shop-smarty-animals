<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 09.10.2015
 */
?>

<!-- TOGGLE -->
<div class="toggle-transparent toggle-bordered-full clearfix">

    <div class="toggle nomargin-top">
        <label>Купон</label>

        <div class="toggle-content" style="display: none;">
            <?= \skeeks\cms\shopDiscountCoupon\ShopDiscountCouponWidget::widget(); ?>
        </div>
    </div>


</div>
<!-- /TOGGLE -->

<div class="toggle-transparent toggle-bordered-full clearfix">
    <div class="toggle active" style="display: block;">
        <div class="toggle-content" style="display: block;">

            <span class="clearfix">
                <span class="pull-right"><?= \Yii::$app->money->convertAndFormat(\Yii::$app->shop->shopFuser->moneyOriginal); ?></span>
                <strong class="pull-left">Товаров:</strong>
            </span>
            <? if (\Yii::$app->shop->shopFuser->moneyDiscount->getValue() > 0) : ?>
                <span class="clearfix">
                    <span class="pull-right"><?= \Yii::$app->money->convertAndFormat(\Yii::$app->shop->shopFuser->moneyDiscount); ?></span>
                    <span class="pull-left">Скидка:</span>
                </span>
            <? endif; ?>

            <? if (\Yii::$app->shop->shopFuser->moneyDelivery->getValue() > 0) : ?>
                <span class="clearfix">
                    <span class="pull-right"><?= \Yii::$app->money->convertAndFormat(\Yii::$app->shop->shopFuser->moneyDelivery); ?></span>
                    <span class="pull-left">Доставка:</span>
                </span>
            <? endif; ?>

            <? if (\Yii::$app->shop->shopFuser->moneyVat->getValue() > 0) : ?>
                <span class="clearfix">
                    <span class="pull-right"><?= \Yii::$app->money->convertAndFormat(\Yii::$app->shop->shopFuser->moneyVat); ?></span>
                    <span class="pull-left">Налог:</span>
                </span>
            <? endif; ?>

            <? if (\Yii::$app->shop->shopFuser->weight > 0) : ?>
                <span class="clearfix">
                    <span class="pull-right"><?= \Yii::$app->shop->shopFuser->weight; ?> г.</span>
                    <span class="pull-left">Вес:</span>
                </span>
            <? endif; ?>

            <hr />

            <span class="clearfix">
                <span class="pull-right size-20"><?= \Yii::$app->money->convertAndFormat(\Yii::$app->shop->shopFuser->money); ?></span>
                <strong class="pull-left">ИТОГ:</strong>
            </span>

            <hr />

            <?= $submit; ?>
        </div>
    </div>
</div>
