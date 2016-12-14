<?
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 11.03.2016
 */
namespace common\models\stockSale;

use common\models\ImportStockSaleModel;
use skeeks\cms\models\CmsContentElementProperty;
use skeeks\cms\models\CmsContentProperty;
use skeeks\cms\models\CmsTree;
use skeeks\cms\models\CmsTreeProperty;
use skeeks\cms\models\CmsTreeTypeProperty;
use skeeks\cms\shop\models\ShopCmsContentElement;
use yii\base\DynamicModel;


/**
 * @property string $column0 //название раздела
 * @property string $column1 //tree id
 * @property string $column2 //tree pid
 * @property string $column9 //ID товара
 * @property string $column10 //ID родительского товара
 * @property string $column11 //Название товара
 * @property string $column24 //Название производителя
 * @property string $column36 //Main image path /upload/shop_11/2/5/9/item_25912/shop_items_catalog_image25912.jpg
 * @property string $column45 //Main image path /upload/shop_11/2/5/9/item_25912/shop_items_catalog_image25912.jpg
 * @property string $column47 //Main image path /upload/shop_11/2/5/9/item_25912/shop_items_catalog_image25912.jpg
 * @property string $column49 //Main image path /upload/shop_11/2/5/9/item_25912/shop_items_catalog_image25912.jpg
 * @property string $column54 //Main image path /upload/shop_11/2/5/9/item_25912/shop_items_catalog_image25912.jpg
 * @property string $column56 //Main image path /upload/shop_11/2/5/9/item_25912/shop_items_catalog_image25912.jpg
 * @property string $column58 //Main image path /upload/shop_11/2/5/9/item_25912/shop_items_catalog_image25912.jpg
 * @property string $column60 //Размер
 * @property string $column61 //Цвет название
 * @property string $column44 //Состав название
 * @property string $column53 //Сезон
 * @property string $column17 //Значение цены
 * @property string $column68 //Наличие
 *
 * Class StockSaleRowModel
 * @package common\models\stockSale
 */
class StockSaleRowModel extends DynamicModel
{
    /**
     * @return array
     */
    public function getAdditionalImages()
    {
        $result = [];

        if ($this->column45)
        {
            $result[] = ImportStockSaleModel::getAbsoluteImageSrc($this->column45);
        }

        if ($this->column47)
        {
            $result[] = ImportStockSaleModel::getAbsoluteImageSrc($this->column47);
        }

        if ($this->column49)
        {
            $result[] = ImportStockSaleModel::getAbsoluteImageSrc($this->column49);
        }

        if ($this->column54)
        {
            $result[] = ImportStockSaleModel::getAbsoluteImageSrc($this->column54);
        }

        if ($this->column56)
        {
            $result[] = ImportStockSaleModel::getAbsoluteImageSrc($this->column56);
        }

        if ($this->column58)
        {
            $result[] = ImportStockSaleModel::getAbsoluteImageSrc($this->column58);
        }

        return $result;
    }
    /**
     * @param array $data строка из CSV
     * @return static
     */
    static public function createFromCsvRow($data = [])
    {
        $dataForModel = [];
        foreach ($data as $number => $value)
        {
            $dataForModel['column' . $number] = trim(iconv('windows-1251', 'UTF-8', $value));
        }

        return new static($dataForModel);
    }


    /**
     * Продукт
     * @return bool
     */
    public function isTree()
    {
        if ($this->column0)
        {
            return true;
        }

        return false;
    }

    /**
     * Продукт
     * @return bool
     */
    public function isProduct()
    {
        if ($this->column9 && !$this->column10)
        {
            return true;
        }

        return false;
    }

    /**
     * Предложение
     * @return bool
     */
    public function isOffer()
    {
        if ($this->column9 && $this->column10)
        {
            return true;
        }

        return false;
    }


    /**
     * @return CmsTree
     */
    public function getCmsTree()
    {
        return CmsTree::find()

            ->joinWith('relatedElementProperties map')
            ->joinWith('relatedElementProperties.property property')

            ->andWhere(['property.code'     => 'stockSaleId'])
            ->andWhere(['map.value'         => $this->column1])

            ->joinWith('treeType as ttype')
            ->andWhere(['ttype.code'        => 'catalog'])

            ->one();

    }

    /**
     * @return CmsTree
     */
    public function getPidCmsTree()
    {

        return CmsTree::find()

            ->joinWith('relatedElementProperties map')
            ->joinWith('relatedElementProperties.property property')

            ->andWhere(['property.code'     => 'stockSaleId'])
            ->andWhere(['map.value'         => $this->column2])

            ->joinWith('treeType as ttype')
            ->andWhere(['ttype.code'        => 'catalog'])

            ->one();
    }

    /**
     * @return null|ShopCmsContentElement
     * @throws \skeeks\cms\relatedProperties\models\InvalidParamException
     */
    public function getCmsContentElementProduct()
    {
        $cmsContent = ShopCmsContentElement::find()

                    ->joinWith('relatedElementProperties map')
                    ->joinWith('relatedElementProperties.property property')

                    ->andWhere(['property.code'     => 'stockSaleId'])
                    ->andWhere(['map.value'         => $this->column9])

                    ->joinWith('cmsContent as ccontent')
                    ->andWhere(['ccontent.code'        => 'product'])

                    ->one()
                ;

        if (!$cmsContent)
        {
            //Иначе создадим
            $cmsContent = new ShopCmsContentElement();
            $cmsContent->tree_id     = 9; //Каталог
            $cmsContent->content_id  = ImportStockSaleModel::CONTENT_PRODUCTS_ID; //Тип контента
            $cmsContent->name        = $this->column11;

            if ($cmsContent->save())
            {
                $cmsContent->relatedPropertiesModel->setAttribute('stockSaleId', $this->column9);
                $cmsContent->relatedPropertiesModel->save();
            }
        }

        return $cmsContent;
    }

    /**
     * @return null|ShopCmsContentElement
     * @throws \skeeks\cms\relatedProperties\models\InvalidParamException
     */
    public function getCmsContentElementOffer()
    {
        $cmsContent = ShopCmsContentElement::find()

                    ->joinWith('relatedElementProperties map')
                    ->joinWith('relatedElementProperties.property property')

                    ->andWhere(['property.code'     => 'stockSaleId'])
                    ->andWhere(['map.value'         => $this->column9])

                    ->joinWith('cmsContent as ccontent')
                    ->andWhere(['ccontent.code'        => 'productChild'])

                    ->one()
                ;


        if (!$cmsContent)
        {
            /**
             * @var $elementPropertyParent CmsContentElementProperty
             */

            $parentElement = ShopCmsContentElement::find()

                    ->joinWith('relatedElementProperties map')
                    ->joinWith('relatedElementProperties.property property')

                    ->andWhere(['property.code'     => 'stockSaleId'])
                    ->andWhere(['map.value'         => $this->column10])

                    ->joinWith('cmsContent as ccontent')
                    ->andWhere(['ccontent.code'        => 'product'])

                    ->one()
                ;

            if (!$parentElement)
            {
                return null;
            }

            //Иначе создадим
            $cmsContent = new ShopCmsContentElement();
            $cmsContent->tree_id     = 9; //Каталог
            $cmsContent->content_id  = ImportStockSaleModel::CONTENT_OFFERS_ID; //Тип контента
            $cmsContent->name        = $this->column11;
            $cmsContent->parent_content_element_id        = $parentElement->id;

            if ($cmsContent->save())
            {
                $cmsContent->relatedPropertiesModel->setAttribute('stockSaleId', $this->column9);
                $cmsContent->relatedPropertiesModel->save();
            }
        }

        return $cmsContent;
    }


}




