<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 06.03.2015
 *
 * @var \skeeks\cms\models\CmsContentElement $model
 *
 */
?>
<? if ($url = $model->relatedPropertiesModel->getAttribute('url')) : ?>
<img onclick="window.location.href='<?= $url; ?>'; return false;" style="cursor: pointer;" class="img-responsive" src="<?= $model->image->src; ?>" alt="<?= $model->name; ?>" title="<?= $model->name; ?>">
<? else: ?>
    <img class="img-responsive" src="<?= $model->image->src; ?>" alt="<?= $model->name; ?>" title="<?= $model->name; ?>">
<? endif; ?>
