<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 25.03.2015
 */
/* @var $this yii\web\View */
/* @var $model \skeeks\cms\models\forms\SignupForm */

use yii\helpers\Html;
use skeeks\cms\base\widgets\ActiveFormAjaxSubmit as ActiveForm;
use \skeeks\cms\helpers\UrlHelper;
?>
<?= $this->render("_header", ['title' => 'Регистрация']); ?>
<div class="col-md-6 col-md-offset-3">

    <div class="box-static box-border-top padding-30">
        <div class="box-title margin-bottom-30">
            <h2 class="size-20">Регистрация</h2>
        </div>

        <?php $form = ActiveForm::begin([
            'action' => UrlHelper::construct('cms/auth/register-by-email')->toString(),
            'validationUrl' => UrlHelper::construct('cms/auth/register-by-email')->setSystemParam(\skeeks\cms\helpers\RequestResponse::VALIDATION_AJAX_FORM_SYSTEM_NAME)->toString(),
        ]); ?>
            <?= $form->field($model, 'email') ?>

            <div class="form-group">
                <?= Html::submitButton("<i class=\"glyphicon glyphicon-off\"></i> Зарегистрироваться", ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

        <?php ActiveForm::end(); ?>
        <?= Html::a('Авторизация', UrlHelper::constructCurrent()->setRoute('cms/auth/login')->toString()) ?>

        <? if (\Yii::$app->authClientCollection->clients) : ?>
            <hr />
            <?= yii\authclient\widgets\AuthChoice::widget([
                 'baseAuthUrl'  => ['/cms/auth/client'],
                 'popupMode'    => true,
            ]) ?>
        <? endif; ?>

    </div>
</div>
<?= $this->render("_footer"); ?>
