<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 25.05.2015
 */
/* @var $this   yii\web\View */
/* @var $widget \skeeks\cms\cmsWidgets\treeMenu\TreeMenuCmsWidget */
/* @var $model   \skeeks\cms\models\Tree */
$dir = $model->dir;
if ($model->redirect_tree_id)
{
    $dir = $model->redirectTree->dir;
};
$hasChildrens = $model->children;
$activeClass = '';
if (strpos(\Yii::$app->request->pathInfo, $dir) !== false)
{
    $activeClass = ' active';
}
?>
<li class="<?= $activeClass; ?> <? ($hasChildrens) ?' dropdown':''; ?>">
    <? if ($hasChildrens) : ?>
        <a href="<?= $model->url; ?>" title="<?= $model->name; ?>" class="dropdownToggle" data-hover="dropdown">
            <?/* if ($icon = $model->relatedPropertiesModel->getAttribute('icon')) : */?><!--
                <img src="<?/*= $icon; */?>" />
            --><?/* endif; */?>
            <span>
            <?= $model->name; ?>
            </span>
        </a>

        <ul class="dropdown-menu">
        <? foreach($model->getChildren()
                       ->andWhere(['active' => $widget->active])
                       ->orderBy([$widget->orderBy => $widget->order])
                       ->all() as $childTree) : ?>
                <li>
                    <a href="<?= $childTree->url; ?>" title="<?= $childTree->name; ?>">
                        <?= $childTree->name; ?>
                    </a>
                </li>
        <? endforeach; ?>
            </ul>
    <? else: ?>
        <a href="<?= $model->url; ?>" title="<?= $model->name; ?>">
            <?/* if ($icon = $model->relatedPropertiesModel->getAttribute('icon')) : */?><!--
                <img src="<?/*= $icon; */?>" style="margin-right: 9px;"/><?/* endif; */?>

            --><?/* endif; */?>
            <span>
            <?= $model->name; ?>
            </span>
        </a>
    <? endif; ?>
</li>