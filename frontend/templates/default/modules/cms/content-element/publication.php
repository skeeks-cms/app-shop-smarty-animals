<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 24.05.2015
 */
/* @var $this \yii\web\View */
/* @var $model \skeeks\cms\models\CmsContentElement */
?>
<?= $this->render('@template/include/breadcrumbs', [
    'model' => $model,
    'title' => '<a href="'.$model->cmsTree->url.'">'.$model->cmsTree->name.'</a>',
])?>

<!-- Product page -->
<section>
    <div class="container">

        <article class="row">
            <div class="col-md-6 col-lg-4 text-center">
                <? if ($model->image) : ?>
                    <img src="<?= $model->image->src; ?>" alt="<?=$model->name; ?>" title="<?=$model->name; ?>" style="max-width: 300px;">
                <? endif; ?>
            </div>
            <div class="col-md-6 col-lg-8">
                <h3><?= $model->name; ?></h3>
                <? if ($model->description_full) : ?>
                    <?=$model->description_full;?>
                <? else : ?>
                    <?=$model->description_short;?>
                <? endif; ?>
            </div>
        </article>
    </div>
</section>



