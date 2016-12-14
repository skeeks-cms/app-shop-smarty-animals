<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 08.03.2016
 */
namespace frontend\controllers;

use skeeks\cms\modules\admin\controllers\AdminController;

class AdminImportStockSale extends AdminController
{
    public function actionIndex()
    {
        return $this->render($this->action->id);
    }
}