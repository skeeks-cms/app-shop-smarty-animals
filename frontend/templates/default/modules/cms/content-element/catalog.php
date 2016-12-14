<?
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 06.03.2015
 */
/* @var $this \yii\web\View */
/* @var \skeeks\cms\models\CmsContentElement $model */
\Yii::$app->assetsAutoCompress->jsFileCompile = false;

$catalogHelper = \common\helpers\CatalogTreeHelper::instance($model);
?>

<?= $this->render('@template/include/breadcrumbs', [
    'model' => $model
])?>

    <? \skeeks\cms\modules\admin\widgets\Pjax::begin(); ?>

    <?
    $this->registerCss(<<<CSS
.checkbox input[type=checkbox]
{
    left:auto;
}
#sx-filters-form label
{
    font-size: 12px;
    color: black;
}
#sx-filters-form input.form-control
{
    height: 30px;
}
CSS
);
    ?>

    <? $filters = new \common\models\ProductFilters(); ?>
    <? $filters->load(\Yii::$app->request->get()); ?>

    <? $shopFilters = \skeeks\cms\shop\cmsWidgets\filters\ShopProductFiltersWidget::begin([
        'namespace' => 'ShopProductFiltersWidget-left-pos-' . $model->cmsContent->id
    ]); ?>





        <!-- Product page -->
        <section class="padding-xxs">
            <div class="container">

                <div class="col-lg-9 col-md-9 col-sm-9 col-lg-push-3 col-md-push-3 col-sm-push-3">



                    <?= \skeeks\cms\cmsWidgets\contentElements\ContentElementsCmsWidget::widget([
                        'namespace' => 'ContentElementsCmsWidget-second-mark',
                        'enabledCurrentTree' => 'N',
                        'viewFile' 	=> '@app/views/widgets/ContentElementsCmsWidget/products',
                        'contentElementClass' => \skeeks\cms\shop\models\ShopCmsContentElement::className(),
                        'dataProviderCallback' 	=> function(\yii\data\ActiveDataProvider $activeDataProvider)
                        use ($filters, $shopFilters)
                        {
                            $activeDataProvider->query->with('relatedProperties');
                            $activeDataProvider->query->with('shopProduct');
                            $activeDataProvider->query->with('shopProduct.baseProductPrice');
                            $activeDataProvider->query->with('shopProduct.minProductPrice');

                            $shopFilters->search($activeDataProvider);
                            $filters->search($activeDataProvider);
                        },
                    ]); ?>

                    <? if($model->description_full && !\Yii::$app->request->get('page')) : ?>
                            <?= $model->description_full; ?>
                    <? endif; ?>

                </div>

                <!-- LEFT -->
                <div class="col-lg-3 col-md-3 col-sm-3 col-lg-pull-9 col-md-pull-9 col-sm-pull-9 sx-bg-silver">

                    <!-- CATEGORIES -->
                    <div class="side-nav margin-bottom-60">

                        <? \skeeks\cms\shop\cmsWidgets\filters\ShopProductFiltersWidget::end(); ?>

                        <!--
                        <?/* $form = \yii\bootstrap\ActiveForm::begin(); */?>
                            <?/* if ($model->children) : */?>
                                <div class="side-nav-head">
                                    <button class="fa fa-bars"></button>
                                    <h4>Разделы</h4>
                                </div>
                                <?/*= \yii\helpers\Html::checkboxList('test', [], \yii\helpers\ArrayHelper::map($model->children, 'id', 'name')); */?>
                            <?/* endif; */?>
                        --><?/* \yii\bootstrap\ActiveForm::end(); */?>



                    </div>
                    <!-- /CATEGORIES -->
                </div>

            </div>
        </section>

    <? \skeeks\cms\modules\admin\widgets\Pjax::end(); ?>



