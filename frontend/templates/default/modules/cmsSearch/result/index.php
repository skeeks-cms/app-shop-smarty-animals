<?
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 06.03.2015
 */
/* @var $this \yii\web\View */

\Yii::$app->breadcrumbs->createBase()
    ->append([
        'name' => 'Результаты поиска',
        'url' => \Yii::$app->request->url,
    ])->append([
        'name' => 'Результаты поиска',
        'url' => 'Результаты поиска',
    ]);
?>
<?= $this->render('@template/include/breadcrumbs', [
    'title' => "Результаты поиска: " . \Yii::$app->cmsSearch->searchQuery . ""
]) ?>

<section class="padding-xxs">
    <div class="row">
        <div class="col-md-12">
            <? \skeeks\cms\modules\admin\widgets\Pjax::begin(); ?>
                    <?= \skeeks\cms\cmsWidgets\contentElements\ContentElementsCmsWidget::widget([
                        'namespace' => 'ContentElementsCmsWidget-search-result',
                        'viewFile' => '@app/views/widgets/ContentElementsCmsWidget/products-list',
                        'enabledCurrentTree' => \skeeks\cms\components\Cms::BOOL_N,
                        'active' => "Y",
                        'dataProviderCallback' => function (\yii\data\ActiveDataProvider $dataProvider) {
                            \Yii::$app->cmsSearch->buildElementsQuery($dataProvider->query);
                            \Yii::$app->cmsSearch->logResult($dataProvider);
                        },
                    ]) ?>
            <? \skeeks\cms\modules\admin\widgets\Pjax::end(); ?>
        </div>
    </div>
</section>
