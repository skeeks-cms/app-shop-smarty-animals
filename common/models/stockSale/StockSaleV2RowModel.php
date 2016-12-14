<?
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 11.03.2016
 */
namespace common\models\stockSale;

use common\models\ImportStockSaleModel;
use common\models\ImportStockSaleV2;
use skeeks\cms\models\CmsContentElementProperty;
use skeeks\cms\models\CmsContentProperty;
use skeeks\cms\models\CmsTree;
use skeeks\cms\models\CmsTreeProperty;
use skeeks\cms\models\CmsTreeTypeProperty;
use skeeks\cms\shop\models\ShopCmsContentElement;
use yii\base\DynamicModel;
use yii\base\Exception;


/**
 * @property string $column0 //название раздела
 * @property string $column1 //название раздела
 * @property string $column2 //название раздела
 * @property string $column3 //Название товара
 * @property string $column4 //ID товара
 * @property string $column5 //ID родительского товара
 * @property string $column6 //Цена
 * @property string $column7 //Название производителя
 * @property string $column8 //Изображение
 * @property string $column9 //Цвет
 * @property string $column10 //Размер
 * @property string $column11 //Состав
 * @property string $column12 //Сезон
 * @property string $column13 //Описание
 * @property string $column14 //Main image path /upload/shop_11/2/5/9/item_25912/shop_items_catalog_image25912.jpg
 * @property string $column15 //Main image path /upload/shop_11/2/5/9/item_25912/shop_items_catalog_image25912.jpg
 * @property string $column16 //Main image path /upload/shop_11/2/5/9/item_25912/shop_items_catalog_image25912.jpg
 * @property string $column17 //Main image path /upload/shop_11/2/5/9/item_25912/shop_items_catalog_image25912.jpg
 * @property string $column18 //Main image path /upload/shop_11/2/5/9/item_25912/shop_items_catalog_image25912.jpg
 * @property string $column19 //Main image path /upload/shop_11/2/5/9/item_25912/shop_items_catalog_image25912.jpg
 * @property string $column20 //quantity
 *
 * Class StockSaleV2RowModel
 * @package common\models\stockSale
 */
class StockSaleV2RowModel extends DynamicModel
{
    /**
     * @return array
     */
    public function getAdditionalImages()
    {
        $result = [];

        if ($this->column14)
        {
            $result[] = ImportStockSaleV2::getAbsoluteImageSrc($this->column14);
        }

        if ($this->column15)
        {
            $result[] = ImportStockSaleV2::getAbsoluteImageSrc($this->column15);
        }

        if ($this->column16)
        {
            $result[] = ImportStockSaleV2::getAbsoluteImageSrc($this->column16);
        }

        if ($this->column17)
        {
            $result[] = ImportStockSaleV2::getAbsoluteImageSrc($this->column17);
        }

        if ($this->column18)
        {
            $result[] = ImportStockSaleV2::getAbsoluteImageSrc($this->column18);
        }

        if ($this->column19)
        {
            $result[] = ImportStockSaleV2::getAbsoluteImageSrc($this->column19);
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
     * Предложение
     * @return bool
     */
    public function isProduct()
    {
        if (!$this->column5)
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
        if ($this->column5)
        {
            return true;
        }

        return false;
    }

    /**
     * Есть данные по разделу
     * @return bool
     */
    public function isTreeData()
    {
        if ($this->column0 && $this->column1)
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
        $importStockSale = new ImportStockSaleV2();
        if (!$tree1 = $importStockSale->rootTree->getChildren()->andWhere(['name' => $this->column0])->one())
        {
            return $importStockSale->rootTree;
        }

        if (!$tree2 = $tree1->getChildren()->andWhere(['name' => $this->column1])->one())
        {
            return $tree1;
        }

        if (!$tree3 = $tree2->getChildren()->andWhere(['name' => $this->column2])->one())
        {
            return $tree2;
        }

        return $tree3;

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
                    ->andWhere(['map.value'         => $this->column4])

                    ->joinWith('cmsContent as ccontent')
                    ->andWhere(['ccontent.code'        => 'product'])

                    ->one()
                ;

        if (!$cmsContent)
        {
            //Иначе создадим
            $cmsContent = new ShopCmsContentElement();
            $cmsContent->tree_id     = ImportStockSaleV2::ROOT_TREE_ID; //Каталог
            $cmsContent->content_id  = ImportStockSaleV2::CONTENT_PRODUCTS_ID; //Тип контента
            $cmsContent->name        = $this->column3;

            if ($cmsContent->save())
            {
                $cmsContent->relatedPropertiesModel->setAttribute('stockSaleId', $this->column4);
                $cmsContent->relatedPropertiesModel->save();
            } else
            {
                throw new Exception("Not created product: " . serialize($cmsContent->getFirstErrors()));
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
                    ->andWhere(['map.value'         => $this->column4])

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
                    ->andWhere(['map.value'         => $this->column5])

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
            $cmsContent->tree_id     = ImportStockSaleV2::ROOT_TREE_ID; //Каталог
            $cmsContent->content_id  = ImportStockSaleV2::CONTENT_OFFERS_ID; //Тип контента
            $cmsContent->name        = $this->column3;
            $cmsContent->parent_content_element_id        = $parentElement->id;

            if ($cmsContent->save())
            {
                $cmsContent->relatedPropertiesModel->setAttribute('stockSaleId', $this->column4);
                $cmsContent->relatedPropertiesModel->save();
            } else
            {
                throw new Exception("Not created offer: " . serialize($cmsContent->getFirstErrors()));
            }
        }

        return $cmsContent;
    }


}




