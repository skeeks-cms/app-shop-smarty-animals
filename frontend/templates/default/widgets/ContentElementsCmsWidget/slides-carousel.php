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


$this->registerJs(<<<JS
$('.carousel').carousel();
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


    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">

         <ol class="carousel-indicators">
            <? for ($i = 0; $i <= $widget->dataProvider->count - 1; $i ++) : ?>
                <?
                    $class = '';
                    if ($i == 0)
                    {
                        $class = 'active';
                    }
                ?>
                <li data-target="#carousel-example-generic" data-slide-to="<?= $i; ?>" class="<?= $class; ?>"></li>
            <? endfor; ?>
         </ol>

        <? echo \yii\widgets\ListView::widget([
            'dataProvider'      => $widget->dataProvider,
            'itemView'          => function($model, $item, $number)
            {

                $class = '';
                if ($number == 0)
                {
                    $class = 'active';
                }

                if ($url = $model->relatedPropertiesModel->getAttribute('url'))
                {
                    return <<<HTML
                    <div class="item {$class}">
                        <img class="img-responsive" onclick="window.location.href='{$url}'; return false;" style="cursor: pointer;" src="{$model->image->src}" alt="{$model->name}" title="{$model->name}">
                    </div>
HTML;
                } else
                {
                    return <<<HTML
                    <div class="item {$class}">
                        <img class="img-responsive" src="{$model->image->src}" alt="{$model->name}" title="{$model->name}">
                    </div>
HTML;

                }

            },
            'emptyText'          => '',
            'options'           =>
            [
                'tag'       => 'div',
                'class'       => 'carousel-inner',
                'role'       => 'listbox',
            ],
            'itemOptions' => [
                'tag' => false,
            ],
            'layout'            => "{items}"
        ])?>

        <!-- Controls -->
          <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" style="box-shadow: none;" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"  style="box-shadow: none;" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
    </div>

<!-- /OWL SLIDER -->

<? elseif ($widget->dataProvider->query->count() == 1) : ?>
    <? $models = $widget->dataProvider->query->all();?>
    <? $model = array_shift($models); ?>
    <img src="<?= $model->image->src; ?>" class="img-responsive" />
<? endif; ?>