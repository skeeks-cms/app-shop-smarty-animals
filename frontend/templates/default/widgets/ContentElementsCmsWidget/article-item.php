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
<!---->
<!--<div class="row margin-bottom-20">-->
<!---->
<!--        --><?// if ($model->image->src) : ?>
<!--    <div class="col-sm-4 sm-margin-bottom-20">-->
<!--           <figure> <img src="--><?//= \skeeks\cms\helpers\Image::getSrc($model->image->src); ?><!----><?///*= \Yii::$app->imaging->getImagingUrl($model->getMainImageSrc(),
//            new \skeeks\cms\components\imaging\filters\Thumbnail([
//                'w'    => 409,
//                'h'    => 258,
//            ])
//        ) */?><!--" alt="--><?//= $model->name; ?><!--" title="--><?//= $model->name; ?><!--" class="img-responsive" />-->
<!--           </figure>-->
<!--    </div>-->
<!--    <div class="col-sm-8 news-v3">-->
<!--        --><?// else :?>
<!--        <div class="col-sm-12 news-v3">-->
<!--        --><?// endif; ?>
<!---->
<!---->
<!---->
<!--        <div class="news-v3-in-sm no-padding">-->
<!--            <h2>-->
<!--                <a href="--><?//= $model->url; ?><!--" title="--><?//= $model->name; ?><!--">--><?//= $model->name; ?><!--</a>-->
<!--            </h2>-->
<!---->
<!--            <!--<ul class="list-inline posted-info">-->
<!--                --><?///* if ($model->createdBy) : */?>
<!--                    <li>Добавил: <a href="--><?///*= $model->createdBy->getPageUrl(); */?><!--" title="--><?///*= $model->createdBy->name; */?><!--">--><?///*= $model->createdBy->name; */?><!--</a></li>-->
<!--                --><?///* endif; */?>
<!--                --><?///* if ($model->cmsTree) : */?>
<!--                    <li>Категория: <a href="--><?///*= $model->cmsTree->url; */?><!--" title="--><?///*= $model->cmsTree->name; */?><!--">--><?///*= $model->cmsTree->name; */?><!--</a></li>-->
<!--                --><?///* endif; */?>
<!--                <li>Время публикации: --><?///*= \Yii::$app->formatter->asDate($model->published_at, 'full')*/?><!--</li>-->
<!--                --><?///* if ($testValue = $model->relatedPropertiesModel->getAttribute('test')) : */?>
<!--                    <li>--><?///*= $model->relatedPropertiesModel->getAttributeLabel('test'); */?><!--: --><?///*= $testValue; */?><!--</li>-->
<!--                --><?///* endif; */?>
<!--            </ul>-->
<!---->
<!--            <div class="news-v3-in-sm-p" >--><?//= $model->description_short; ?><!--</div>-->
<!--            <p><a href="--><?//= $model->url; ?><!--" data-pjax="0" class="btn btn-color">Подробнее</a></p>-->
<!---->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<!--<div class="clearfix margin-bottom-20"><hr></div>-->


    <div class="blog-post-item col-md-3 col-sm-3">

        <!-- IMAGE -->
                <figure>
                    <img src="<?= \skeeks\cms\helpers\Image::getSrc($model->image->src); ?><? /*= \Yii::$app->imaging->getImagingUrl($model->getMainImageSrc(),
        new \skeeks\cms\components\imaging\filters\Thumbnail([
        'w'    => 409,
        'h'    => 258,
        ])
        ) */ ?>" alt="<?= $model->name; ?>" title="<?= $model->name; ?>" class="img-responsive" style="max-height: 150px;"/>
                </figure>

        <h2><a href="<?= $model->url; ?>" title="<?= $model->name; ?>"><?= $model->name; ?></a></h2>
        <ul class="blog-post-info list-inline">
								<li>
									<a href="#">
										<i class="fa fa-clock-o"></i>
										<span class="font-lato"><?= \Yii::$app->formatter->asDate($model->published_at, 'full')?></span>
									</a>
								</li>
        </ul>

        <p><?= $model->description_short; ?></p>

        <a href="<?= $model->url; ?>" data-pjax="0" class="btn btn-reveal btn-default">
            <i class="fa fa-plus"></i>
            <span>Подробнее</span>
        </a>
    </div>
