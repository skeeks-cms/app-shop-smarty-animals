<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 08.03.2016
 */
namespace frontend\controllers;

use skeeks\cms\helpers\RequestResponse;
use skeeks\cms\models\Tree;
use skeeks\cms\modules\admin\controllers\AdminController;

class AdminImportStockSaleController extends AdminController
{
    public function actionIndex()
    {
        $rr = new RequestResponse();
        $model = new \common\models\ImportStockSaleModel();

        if (\Yii::$app->request->isAjax && \Yii::$app->request->post())
        {
            $model->load(\Yii::$app->request->post());

            $rr->success = true;
            $rr->message = "Импорт завершен успешно";




            $rr->data = [
                'countRows' => $model->countRows(),
                'resultImportTree' => $model->importTree()
            ];

            return $rr;
        }

        return $this->render($this->action->id, [
            'model' => $model
        ]);
    }

    public function actionValidate()
    {
        $rr = new RequestResponse();
        $model = new \common\models\ImportStockSaleModel();
        if (\Yii::$app->request->isAjax && \Yii::$app->request->post())
        {
            $model->load(\Yii::$app->request->post());
            return $rr->ajaxValidateForm($model);
        }
    }
    public function actionImportProduct()
    {
        $rr = new RequestResponse();
        $model = new \common\models\ImportStockSaleModel();
        if (\Yii::$app->request->isAjax && \Yii::$app->request->post())
        {
            $model->importFilePath = \Yii::$app->request->post('importfilepath');
            $model->importProducts(\Yii::$app->request->post('rowStart'), \Yii::$app->request->post('rowEnd'));

            $rr->success = true;
            return $rr;
        }
    }
}