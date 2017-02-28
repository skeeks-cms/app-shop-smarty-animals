<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 08.11.2016
 */
/* @var $this yii\web\View */
/* @var $model \skeeks\cms\models\CmsContentElement */
if ($model->parentContentElement)
{
    \Yii::$app->response->redirect($model->parentContentElement->url . "?sx-offer=" . $model->id);
}