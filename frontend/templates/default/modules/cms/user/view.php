<?php
use yii\helpers\Html;

use yii\widgets\ActiveForm;
/**
 * index
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010-2014 SkeekS (Sx)
 * @date 14.10.2014
 * @since 1.0.0
 */

/* @var $this       yii\web\View */
/* @var $context    \frontend\controllers\UserController */
/* @var $model      common\models\User */

$context = $this->context;
$model = $context->user;

$this->title = $model->getDisplayName();
\Yii::$app->breadcrumbs->createBase()->append($this->title);

\Yii::$app->response->redirect($model->getPageUrl('edit'));
?>

<?= $this->render('_header', [
    'model'     => $model,
    'title'     => 'Профиль',
]); ?>


<?= $this->render('_footer'); ?>



