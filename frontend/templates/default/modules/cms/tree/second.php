<?
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (ÑêèêÑ)
 * @date 06.03.2015
 */
/* @var $this \yii\web\View */
/* @var \skeeks\cms\models\Tree $model */
?>

<?= $this->render('@template/include/breadcrumbs', [
    'model' => $model
])?>

<!--=== Content Part ===-->
<div class="container content">
    <div class="row magazine-page">
        <div class="col-md-12 sx-content">
            <?= $model->description_full; ?>
        </div>
    </div>
</div>