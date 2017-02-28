<?
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 06.03.2015
 */
/* @var $this \yii\web\View */
/* @var \skeeks\cms\models\CmsContentElement $model */
?>
<?= $this->render('@template/include/breadcrumbs', [
    'model' => $model
])?>

<!--=== Content Part ===-->
<div class="container content">
    <div class="row magazine-page">
        <? $colLeft = trim($this->render('@template/include/col-left.php')); ?>
        <? if ($colLeft) : ?>
            <div class="col-md-3">
                <?= $colLeft; ?>
            </div>
        <? endif; ?>

        <div class="<?= $colLeft ? "col-md-9" : "col-md-12"; ?> sx-content">
            <?= $model->description_full; ?>

            <? if ($images = $model->images) : ?>
            <div class="row">
                <? foreach($images as $image) : ?>
                    <a href="<?= $image->src; ?>" title="<?= $model->name; ?>" class="sx-fancybox col-md-3 lup-img" style="float: left; margin-top: 10px;" rel="sx-fancybox-group" data-fancybox-group="gallery">
                        <span class="fullscreen mg-top" ><i class="fa fa-search"></i></span><img class="responsive" alt="<?= $model->name; ?>" title="<?= $model->name; ?>" src="<?= $image->src; ?>"  />
                    
                    </a>
                <? endforeach; ?>
            </div>
            <? endif; ?>
        </div>
    </div>
</div>