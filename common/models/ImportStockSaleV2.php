<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 08.03.2016
 */
namespace common\models;

use common\models\stockSale\StockSaleProductModel;
use common\models\stockSale\StockSaleRowModel;
use skeeks\cms\models\CmsContentElement;
use skeeks\cms\models\CmsContentPropertyEnum;
use skeeks\cms\models\CmsTree;
use skeeks\cms\shop\models\ShopProduct;
use yii\base\Model;

/**
 * @property string $rootPath
 * @property CmsTree $rootTree
 *
 * Class ImportStockSaleModel
 * @package common\models
 */
class ImportStockSaleV2 extends Model
{
    const COLORS_CONTENT_ID = 11;
    const BRANDS_CONTENT_ID = 9;
    const CONTENT_PRODUCTS_ID = 2;
    const CONTENT_OFFERS_ID = 10;
    const TREE_TYPE_ID = 5;

    const ROOT_TREE_ID = 9;

    const BASE_URL = "http://stock-sale.ru";


    public $_rootPath;

    /**
     * @return bool|string
     */
    public function getRootPath()
    {
        if ($this->_rootPath)
        {
            return $this->_rootPath;
        }
        $this->_rootPath = \Yii::getAlias('@frontend/web/import/stock-sale/import.csv');

        return $this->_rootPath;
    }
    /**
     * @return bool|string
     */
    public function setRootPath($path)
    {
        $this->_rootPath = $path;
    }

    /**
     * @return null|static
     */
    public function getRootTree()
    {
        return CmsTree::findOne(static::ROOT_TREE_ID);
    }

    /**
     * Количество строк
     * @return int
     */
    public function countRows()
    {
        $counter = 0;
        $handle = fopen($this->rootPath, "r");
        while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
            $counter++;
        }

        return $counter;
    }


    /**
     * @param $path
     * @return string
     */
    static public function getAbsoluteImageSrc($path)
    {
        return self::BASE_URL . $path;
    }
}