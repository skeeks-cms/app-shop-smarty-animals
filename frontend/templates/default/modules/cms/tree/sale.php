<?
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 06.03.2015
 */
/* @var $this \yii\web\View */
/* @var \skeeks\cms\models\Tree $model */
$catalogHelper = \common\helpers\CatalogTreeHelper::instance($model);

$this->registerJs(<<<JS
//inner-wrapper scrollbar-macosx scroll-content scroll-scrollx_visible scroll-scrolly_visible

JS
);
?>

<?= $this->render('@template/include/breadcrumbs', [
    'model' => $model
])?>



<section style="padding-top: 20px;">
        <div class="container">

                <div class="col-md-12">


<? $widgetElements = new \skeeks\cms\cmsWidgets\contentElements\ContentElementsCmsWidget([
    'namespace' => 'ContentElementsCmsWidget-second',
    'viewFile' 	=> '@app/views/widgets/ContentElementsCmsWidget/products',
    'contentElementClass'         => \skeeks\cms\shop\models\ShopCmsContentElement::className(),
    'dataProviderCallback' 	=> function(\yii\data\ActiveDataProvider $activeDataProvider)
    {

        $activeDataProvider->query->with('relatedProperties');
        $activeDataProvider->query->with('shopProduct');
        $activeDataProvider->query->with('shopProduct.baseProductPrice');
        $activeDataProvider->query->with('shopProduct.minProductPrice');
        //$activeDataProvider->query->joinWith('shopProduct.baseProductPrice as basePrice');
        //$activeDataProvider->query->orderBy(['basePrice' => SORT_ASC]);
    },
]); ?>

<? $resultElements = $widgetElements->run(); ?>

                            <?= $resultElements; ?>


                        </div>
            </div>

</section>

