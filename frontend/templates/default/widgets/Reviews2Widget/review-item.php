<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 10.07.2015
 *
 * @var \skeeks\cms\reviews2\models\Reviews2Message $model
 */
/* @var $this yii\web\View */

?>

<div class="row margin-bottom-20">
    <div class="col-lg-3">
        <? if ($model->createdBy) : ?>
            <a href="<?= $model->createdBy->getPageUrl(); ?>">
                <img src="<?= $model->createdBy->getAvatarSrc(); ?>" style="float: left; padding-right: 10px;"/>
                <?= $model->createdBy->displayName; ?>
            </a>
        <? else : ?>
            <img src="<?= \skeeks\cms\helpers\Image::getCapSrc(); ?>" style="float: left; padding-right: 10px; width: 50px;"/>
            Гость
        <? endif; ?>
    </div>
    <div class="col-lg-9">

        <p>
            <?=
                \kartik\rating\StarRating::widget([
                    'name' => 'rating_1',
                    'value' => $model->rating,
                    'pluginOptions' => [
                        'disabled'  => true,
                        'showClear' => false,
                        'size'      => 'sx',
                        'starCaptions' =>
                        [
                            1 => 'Очень плохо',
                            2 => 'Плохо',
                            3 => 'Нормально',
                            4 => 'Хорошо',
                            5 => 'Отлично',
                        ]
                    ]
                ]);
            ?>
            <?= \Yii::$app->formatter->asDatetime($model->published_at); ?>
        </p>
        <? if ($model->comments) : ?>
            <p>
            <b>Комментарий:</b><br />
            <?= $model->comments; ?>
            </p>
        <? endif; ?>

        <? if ($model->dignity) : ?>
            <p>
            <b>Достоинства:</b><br />
            <?= $model->dignity; ?>
            </p>
        <? endif; ?>

        <? if ($model->disadvantages) : ?>
            <p>
            <b>Недостатки:</b><br />
            <?= $model->disadvantages; ?>
            </p>
        <? endif; ?>
    </div>
    <div class="col-lg-12">
        <hr />
    </div>
</div>
