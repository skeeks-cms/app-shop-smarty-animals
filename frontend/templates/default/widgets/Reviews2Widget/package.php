<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 07.07.2015
 */
/* @var $this yii\web\View */
/* @var $widget \skeeks\cms\reviews2\widgets\reviews2\Reviews2Widget */
$model = $widget->modelMessage;
$pjaxId = $widget->id . "-pjax";
$this->registerJs(<<<JS
(function(sx, $, _)
{
    sx.classes.AddRview2 = sx.classes.Component.extend({

        _onDomReady: function()
        {
            $(".sx-toggle-add-review2").on("click", function()
            {
                $("#sx-add-review2").toggle();
                return false;
            });
        },
    });

    new sx.classes.AddRview2();
})(sx, sx.$, sx._);
JS
);
?>
<div class="row">
    <div class="col-md-12 col-lg-12">
        <a href="#" class="btn btn-primary sx-toggle-add-review2 pull-right"><i class="glyphicon glyphicon-plus"></i>
            Добавить отзыв</a>
    </div>
</div>
<div id="sx-add-review2" style="display: none;">
    <? $form = \skeeks\cms\base\widgets\ActiveFormAjaxSubmit::begin([
        'action' => \skeeks\cms\helpers\UrlHelper::construct('/reviews2/backend/submit')->toString(),
        'validationUrl' => \skeeks\cms\helpers\UrlHelper::construct('/reviews2/backend/submit')->enableAjaxValidateForm()->toString(),
        'afterValidateCallback' => new \yii\web\JsExpression(<<<JS
    function(jQueryForm, AjaxQuery)
    {
        var handler = new sx.classes.AjaxHandlerStandartRespose(AjaxQuery, {
            'blockerSelector' : '#' + jQueryForm.attr('id'),
            'enableBlocker' : true,
        });

        handler.bind('success', function(e, response)
        {
            jQueryForm.empty().append(response.message);
            $.pjax.reload('#{$pjaxId}');
        });

        handler.bind('error', function(e, response)
        {
            $('.sx-captcha-wrapper img', jQueryForm).click();
        });


    }
JS
        )
    ]); ?>

    <?= $form->field($model, 'element_id')->hiddenInput([
        'value' => $widget->cmsContentElement->id
    ])->label(false); ?>


    <?= $form->field($model, 'rating')->widget(\kartik\rating\StarRating::classname(), [
        'pluginOptions' => [
            'size' => 'lg',
            'step' => 1,
            'clearCaption' => 'Не выбрано',
            'showClear' => false,
            'starCaptions' =>
                [
                    1 => 'Очень плохо',
                    2 => 'Плохо',
                    3 => 'Нормально',
                    4 => 'Хорошо',
                    5 => 'Отлично',
                ]
        ]
    ]); ?>
    <? /*= $form->field($model, 'rating')->radioList(\Yii::$app->reviews2->ratings); */ ?>
    <? if (\Yii::$app->user->isGuest) : ?>
        <? if (in_array('user_name', \Yii::$app->reviews2->enabledFieldsOnGuest)): ?>
            <?= $form->field($model, 'user_name')->textInput(); ?>
        <? endif; ?>
        <? if (in_array('user_email', \Yii::$app->reviews2->enabledFieldsOnGuest)): ?>
            <?= $form->field($model, 'user_email')->hint('Email не будет опубликован публично')->textInput(); ?>
        <? endif; ?>
        <? if (in_array('comments', \Yii::$app->reviews2->enabledFieldsOnGuest)): ?>
            <?= $form->field($model, 'comments')->textarea([
                'rows' => 5
            ]); ?>
        <? endif; ?>
        <? if (in_array('dignity', \Yii::$app->reviews2->enabledFieldsOnGuest)): ?>
            <?= $form->field($model, 'dignity')->textarea([
                'rows' => 5
            ]); ?>
        <? endif; ?>
        <? if (in_array('disadvantages', \Yii::$app->reviews2->enabledFieldsOnGuest)): ?>
            <?= $form->field($model, 'disadvantages')->textarea([
                'rows' => 5
            ]); ?>
        <? endif; ?>
        <? if (in_array('verifyCode', \Yii::$app->reviews2->enabledFieldsOnGuest)): ?>
            <?= $form->field($model, 'verifyCode')->widget(\skeeks\cms\captcha\Captcha::className()) ?>
        <? endif; ?>
    <? else: ?>
        <? if (in_array('user_name', \Yii::$app->reviews2->enabledFieldsOnUser)): ?>
            <?= $form->field($model, 'user_name')->textInput(); ?>
        <? endif; ?>
        <? if (in_array('user_email', \Yii::$app->reviews2->enabledFieldsOnUser)): ?>
            <?= $form->field($model, 'user_email')->hint('Email не будет опубликован публично')->textInput(); ?>
        <? endif; ?>
        <? if (in_array('comments', \Yii::$app->reviews2->enabledFieldsOnUser)): ?>
            <?= $form->field($model, 'comments')->textarea([
                'rows' => 5
            ]); ?>
        <? endif; ?>
        <? if (in_array('dignity', \Yii::$app->reviews2->enabledFieldsOnUser)): ?>
            <?= $form->field($model, 'dignity')->textarea([
                'rows' => 5
            ]); ?>
        <? endif; ?>
        <? if (in_array('disadvantages', \Yii::$app->reviews2->enabledFieldsOnUser)): ?>
            <?= $form->field($model, 'disadvantages')->textarea([
                'rows' => 5
            ]); ?>
        <? endif; ?>
        <? if (in_array('verifyCode', \Yii::$app->reviews2->enabledFieldsOnUser)): ?>
            <?= $form->field($model, 'verifyCode')->widget(\skeeks\cms\captcha\Captcha::className()) ?>
        <? endif; ?>
    <? endif; ?>


    <?= \yii\helpers\Html::submitButton("" . \Yii::t('app', $widget->btnSubmit), [
        'class' => $widget->btnSubmitClass,
    ]); ?>
    <? \skeeks\cms\base\widgets\ActiveFormAjaxSubmit::end(); ?>
</div>
<hr/>
<? if ($widget->enabledPjaxPagination == \skeeks\cms\components\Cms::BOOL_Y) : ?>
    <? \skeeks\cms\modules\admin\widgets\Pjax::begin([
        'id' => $pjaxId,
    ]); ?>
<? endif; ?>

<? echo \yii\widgets\ListView::widget([
    'dataProvider' => $widget->dataProvider,
    'itemView' => 'review-item',
    'emptyText' => '',
    'options' =>
        [
            'tag' => 'div',
        ],
    'itemOptions' => [
        'tag' => false
    ],
    'layout' => "\n{items}{summary}\n<p class=\"row\">{pager}</p>"
]) ?>

<? if ($widget->enabledPjaxPagination == \skeeks\cms\components\Cms::BOOL_Y) : ?>
    <? \skeeks\cms\modules\admin\widgets\Pjax::end(); ?>
<? endif; ?>
