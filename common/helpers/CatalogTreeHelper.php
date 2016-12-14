<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (ÑêèêÑ)
 * @date 22.09.2015
 */
namespace common\helpers;

use skeeks\cms\helpers\CmsTreeHelper;
use yii\helpers\ArrayHelper;

/**
 * @property string $viewType
 *
 * Class CatalogTreeHelper
 * @package common\helpers
 */
class CatalogTreeHelper extends CmsTreeHelper
{
    const VIEW_TREE     = 'tree';
    const VIEW_PRODUCT  = 'product';

    public function getViewType()
    {
        if (!$value = ArrayHelper::getValue($this->model->relatedPropertiesModel, 'viewType'))
        {
            return self::VIEW_TREE;
        }

        $property = $this->model->relatedPropertiesModel->getRelatedProperty('viewType');
        $enum = $property->getEnums()->andWhere(['id' => $value])->one();
        return $enum->code;
    }
}