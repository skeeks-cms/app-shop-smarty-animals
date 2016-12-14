<?
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (ÑêèêÑ)
 * @date 06.03.2015
 */
/* @var $this \yii\web\View */
/* @var \skeeks\cms\models\Tree $model */

$opacity = $model->relatedPropertiesModel->getAttribute("opacity");
?>

<?= $this->render('@template/include/breadcrumbs', [
    'model' => $model
])?>

<!--=== Content Part ===-->
<section class="padding-xxs" <?= $opacity ? "style='opacity: {$opacity};'": ""?>>
    <div class="container content">
        <div class="row">
            <div class="col-md-12 sx-content">
                <?= $model->description_full; ?>

                <?= trim(\skeeks\cms\cmsWidgets\treeMenu\TreeMenuCmsWidget::widget([
                    'namespace'         => 'TreeMenuCmsWidget-sub-catalog',
                    'viewFile'          => '@app/views/widgets/TreeMenuCmsWidget/sub-catalog',
                    'treePid'           => $model->id,
                    'enabledRunCache'   => \skeeks\cms\components\Cms::BOOL_N,
                ])); ?>

                <?= \skeeks\cms\cmsWidgets\contentElements\ContentElementsCmsWidget::widget([
                    'namespace'         => 'ContentElementsCmsWidget-sub-catalog',
                    'viewFile'          => '@app/views/widgets/ContentElementsCmsWidget/articles',
                    //'treePid'           => $model->id,
                    //'enabledRunCache'   => \skeeks\cms\components\Cms::BOOL_N,
                ]); ?>

            </div>
        </div>
    </div>
</section>