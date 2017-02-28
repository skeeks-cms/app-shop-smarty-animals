<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (�����)
 * @date 29.10.2015
 */
/* @var $this yii\web\View */
/* @var $model \skeeks\cms\models\CmsTree */
/* @var $activeModel \skeeks\cms\models\CmsTree */
$active = false;
$parentsIds = \yii\helpers\ArrayHelper::map($activeModel->parents, 'id', 'id');
$parentsIds[] = $activeModel->id;
if (in_array($model->id, $parentsIds))
{
    $active = true;
}

$children = $model->getChildren()->andWhere(['active' => "Y"])->all();
?>
<li class="<?= $active ? "active": ""?> sx-level-<?= $model->level; ?>">
    <a href="<?= $model->url; ?>" title="<?= $model->name; ?>" class="<?= $active ? "active": ""?>" data-pjax="0">
        <?= $model->name; ?>

        <? if ($children) : ?>
            <span class="caret"></span>
        <? endif; ?>
    </a>
    <?/* if ($active) : */?><!--
        <?/* if ($children) : */?>
            <ul>
                <?/* foreach($children as $childTree) : */?>
                    <?/*= $this->render('_left-menu', [
                        'model'         => $childTree,
                        'activeModel'   => $activeModel,
                    ]); */?>
                <?/* endforeach; */?>
            </ul>
        <?/* endif; */?>
    --><?/* endif; */?>
</li>