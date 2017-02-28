<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 25.05.2015
 */
/* @var $this   yii\web\View */
/* @var $widget \skeeks\cms\cmsWidgets\contentElements\ContentElementsCmsWidget */
\frontend\assets\OwnCarouselAsset::register($this);
$this->registerJs(<<<JS
new sx.classes.OwnCarousel({
	'jsquerySelector' : '.owl-carousel'
});
JS
);
?>
<? if ($models = $widget->dataProvider->query->andWhere(['>', 'image_id', 0])->all()) : ?>



    <div class="owl-carousel nomargin" data-plugin-options='{"singleItem": false, "autoPlay": 3000, "items": 6}'>
    <? foreach($models as $model) : ?>
         <?
$dataQuery = [];

$dataQuery['mode'] = 'products';
$dataQuery['SearchRelatedPropertiesModel']['brand'] = [$model->id];
$url = "/catalog?" . http_build_query($dataQuery);
    ?>

        <div>
            <a href="<?= $url; ?>">
                <img style="max-height: 80px; max-width: 150px;" src="<?= $model->image->src; ?>" alt="">
            </a>
        </div>
    <? endforeach; ?>
    </div>
<? endif; ?>