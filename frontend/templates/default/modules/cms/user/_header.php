<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 25.03.2015
 */
/* @var $this yii\web\View */
/* @var $model \common\models\User */

use yii\helpers\Html;
use skeeks\cms\base\widgets\ActiveFormAjaxSubmit as ActiveForm;
use \skeeks\cms\helpers\UrlHelper;

$this->title = $model->getDisplayName() . ' / ' . $title;

\Yii::$app->breadcrumbs->createBase()->append([
    'name' => $model->displayName,
    'url'  => $model->getPageUrl()
])->append([
    'name' => $title
]);
?>

<?= $this->render('@template/include/breadcrumbs', [
    'model' => $model
])?>


<section style="padding-top: 40px;">
    <!--=== Content Part ===-->
    <div class="container content profile sx-profile">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-4">




                <ul class="side-nav list-group margin-bottom-60" id="sidebar-nav">

                    <!--<li class="list-group-item <?/*= \Yii::$app->controller->action->uniqueId == 'cms/user/view' ? "active": ""*/?>">
                        <a href="<?/*= $model->getPageUrl('view')*/?>"><i class="glyphicon glyphicon-calendar"></i> Профиль</a>
                    </li>-->

                    <? if (!\Yii::$app->user->isGuest && \Yii::$app->user->identity->id == $model->id) : ?>

                        <li class="list-group-item <?= in_array(\Yii::$app->controller->action->uniqueId, ['shop/order/list', 'shop/order/view']) ? "active": ""?>">
                            <a href="<?= \yii\helpers\Url::to(['/shop/order/list'])?>"><i class="fa fa-tasks"></i> Заказы</a>
                        </li>

                        <li class="list-group-item <?= \Yii::$app->controller->action->id == 'edit' ? "active": ""?>">
                            <a href="<?= $model->getPageUrl('edit')?>"><i class="fa fa-cog"></i> Настройки</a>
                        </li>

                        <li class="list-group-item">
                            <a href="<?= \skeeks\cms\helpers\UrlHelper::construct('cms/auth/logout')->setRef('/'); ?>" data-method="post"><i class="glyphicon glyphicon-off"></i> Выход</a>
                        </li>

                    <? endif; ?>

                </ul>


            </div>


            <div class="col-lg-9 col-md-9 col-sm-8">
                <div class="profile-body">



