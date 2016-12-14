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
$dataQuery = [];

$dataQuery['mode'] = 'products';
$dataQuery['SearchRelatedPropertiesModel']['brand'] = [$model->id];
$url = "/catalog?" . http_build_query($dataQuery);
?>
<div class="blog-post-item col-md-2 col-sm-3">

    <!-- IMAGE -->
            <figure>
                <a href="<?= $url ?>">
                    <img src="<?= \skeeks\cms\helpers\Image::getSrc($model->image ? $model->image->src : null); ?>" alt="<?= $model->name; ?>" title="<?= $model->name; ?>" class="img-responsive"
                         style="max-height: 150px; max-width: 150px;"/>
                </a>
            </figure>

    <h2><a href="<?= $url ?>" title="<?= $model->name; ?>"><?= $model->name; ?></a></h2>
</div>
