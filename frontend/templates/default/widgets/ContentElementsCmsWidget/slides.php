<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 25.05.2015
 */
/* @var $this   yii\web\View */
/* @var $widget \skeeks\cms\cmsWidgets\contentElements\ContentElementsCmsWidget */



?>
<? if ($widget->dataProvider->query->count() > 1) : ?>
<!-- OWL SLIDER -->
    <?

\frontend\assets\OwnCarouselAsset::register($this);

$this->registerJs(<<<JS
new sx.classes.OwnCarousel({
	'jsquerySelector' : '.owl-carousel'
});
/*

$('.custom1').owlCarousel({
    animateOut: 'slideOutDown',
    animateIn: 'flipInX',
    items:1,
    margin:30,
    stagePadding:30,
    smartSpeed:450
});*/

JS
);
    ?>
    <? echo \yii\widgets\ListView::widget([
        'dataProvider'      => $widget->dataProvider,
        'itemView'          => 'slide-item',
        'emptyText'          => '',
        'options'           =>
        [
            'tag'       => 'div',
            'class'       => 'owl-carousel buttons-autohide controlls-over nomargin',
            'data-plugin-options'       => '{"items": 1, "autoHeight": false, "navigation": true, "pagination": false, "transitionStyle":"fade", "progressBar":"true", "animateOut": "slideOutDown", "animateIn": "flipInX"}',
        ],
        'itemOptions' => [
            'tag' => "div"
        ],
        'layout'            => "{items}"
    ])?>

<!-- /OWL SLIDER -->

<? elseif ($widget->dataProvider->query->count() == 1) : ?>
    <? $models = $widget->dataProvider->query->all();?>
    <? $model = array_shift($models); ?>
    <img src="<?= $model->image->src; ?>" class="img-responsive" />
<? endif; ?>