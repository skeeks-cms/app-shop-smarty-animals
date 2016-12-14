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
$activeClass = '';
if (strpos(\Yii::$app->request->pathInfo, $model->dir) !== false)
{
    $activeClass = ' active';
}
$prod_id = \skeeks\cms\models\CmsContent::find()->where(['code' => 'product'])->one()->id;
$ids = \yii\helpers\ArrayHelper::merge([$model->id], \yii\helpers\ArrayHelper::map($model->children, 'id', 'id'));
$products_list = [];
foreach ($ids as $id)
{
    $products = \skeeks\cms\models\CmsContentElement::find()->where(['content_id' => $prod_id, 'tree_id' => $id])->all();
    $products_list = \yii\helpers\ArrayHelper::merge($products_list, $products);
}

?>
<? if(count($products_list)) : ?>
    <div class="heading-title heading-border-bottom heading-color">
        <h2 class="size-20"><?=$model->name;?></h2>
    </div>
    <div class="">
        <?= \skeeks\cms\cmsWidgets\contentElements\ContentElementsCmsWidget::widget([
            'namespace'                     => 'ContentElementsCmsWidget-home-1',
            'viewFile' 	                    => '@app/views/widgets/ContentElementsCmsWidget/products',
            'label' 	                    => '',
            'limit' 	                    => 6,
            'enabledCurrentTree' 	        => \skeeks\cms\components\Cms::BOOL_N,
            'enabledSearchParams' 	        => \skeeks\cms\components\Cms::BOOL_N,
            'enabledCurrentTreeChild' 	    => \skeeks\cms\components\Cms::BOOL_N,
            'enabledCurrentTreeChildAll' 	=> \skeeks\cms\components\Cms::BOOL_N,
            'content_ids' 	                => [$prod_id],
            'tree_ids' 	                    => $ids
        ]); ?>
    </div>
<? endif; ?>