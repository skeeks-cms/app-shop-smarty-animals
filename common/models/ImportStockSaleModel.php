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
 *
 * Class ImportStockSaleModel
 * @package common\models
 */
class ImportStockSaleModel extends Model
{
    const COLORS_CONTENT_ID = 11;
    const BRANDS_CONTENT_ID = 9;
    const CONTENT_PRODUCTS_ID = 2;
    const CONTENT_OFFERS_ID = 10;
    const TREE_TYPE_ID = 5;

    const BASE_URL = "http://stock-sale.ru";

    public $importFilePath = null;

    public function rules()
    {
        return [
            ['importFilePath' , 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'importFilePath' => 'Файл импорта товаров'
        ];
    }

    /**
     * @return bool|string
     */
    public function getRootPath()
    {
        return \Yii::getAlias('@frontend/web' . $this->importFilePath);
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

    public function importTree()
    {
        $counter = 0;
        $handle = fopen($this->rootPath, "r");
        $added = 0;
        $notAdd = 0;
        $notFoundID = 0;
        $addedElements = [];
        $notAddedElements = [];

        while (($data = fgetcsv($handle, 0, ";")) !== FALSE)
        {
            $counter++;
            $row = StockSaleRowModel::createFromCsvRow($data);

            $counter ++;

            if ($row->isTree())
            {

                if ($row->getCmsTree())
                {
                    continue;
                } else
                {
                    if ($row->column1)
                    {
                        $childNodeNew = new CmsTree();
                        $childNodeNew->name = $row->column0;

                        if ($parent = $row->getPidCmsTree())
                        {
                            if ($parent->processAddNode($childNodeNew))
                            {
                                $childNodeNew->relatedPropertiesModel->setAttribute('stockSaleId', $row->column1);

                                if ($childNodeNew->relatedPropertiesModel->save())
                                {
                                    $addedElements[] = [
                                        $childNodeNew->name, $row->column1
                                    ];

                                    $added ++;
                                } else
                                {
                                    $notAdd ++;

                                    $notAddedElements[] = [
                                        $childNodeNew->name, $row->column1
                                    ];


                                    \Yii::error('not add tree: ' . $childNodeNew->name, 'import');
                                    $childNodeNew->delete();
                                }
                            }
                        }
                    } else
                    {
                        $notFoundID ++;
                    }

                }
            }
        }

        return [
            'added' => $added,
            'notAdd' => $notAdd,
            'notFoundID' => $notFoundID,
            'addedElements' => $addedElements,
            'notAddedElements' => $notAddedElements
        ];
    }

    public function importProducts($rowStart = 1, $rowEnd = 10)
    {
        $counter = 0;
        $handle = fopen($this->rootPath, "r");
        $dataKeys = [];
        while (($data = fgetcsv($handle, 0, ";")) !== FALSE)
        {
            $counter ++;

            if ($counter > $rowEnd)
            {
                break;
            }

            if ($counter >= $rowStart && $counter <= $rowEnd && $counter > 1)
            {
                $row = StockSaleRowModel::createFromCsvRow($data);
                if ($row->isProduct())
                {
                    $cmsContentElement = $row->getCmsContentElementProduct();
                    if ($cmsContentElement)
                    {
                        $shopProduct = $cmsContentElement->shopProduct;

                        if (!$shopProduct)
                        {
                            $shopProduct = new ShopProduct();
                            $shopProduct->id = $cmsContentElement->id;
                            $shopProduct->save();
                        }

                        if ($shopProduct)
                        {
                            $shopProduct->baseProductPriceValue = $row->column17;
                            $shopProduct->baseProductPriceCurrency = "RUB";
                            $shopProduct->quantity = $row->column68;
                            $shopProduct->product_type = ShopProduct::TYPE_OFFERS;

                            $shopProduct->save();
                        }

                        //Состав
                        if ($row->column44)
                        {
                            $cmsContentElement->relatedPropertiesModel->setAttribute('composition', $row->column44);
                        }

                        //Сезон
                        if ($row->column53)
                        {
                            if ($property = $cmsContentElement->relatedPropertiesModel->getRelatedProperty('season'))
                            {
                                if ( $enum = $property->getEnums()->andWhere(['value' => $row->column53])->one() )
                                {

                                } else
                                {
                                    $enum = new CmsContentPropertyEnum();
                                    $enum->value = $row->column53;
                                    $enum->property_id = $property->id;
                                    $enum->save();
                                }

                                if ($enum && !$enum->isNewRecord)
                                {
                                    $cmsContentElement->relatedPropertiesModel->setAttribute('season', $enum->id);
                                }
                            }
                        }

                        //Брэнд
                        if ($row->column24)
                        {
                            $brand = CmsContentElement::find()
                                ->where(['content_id' => self::BRANDS_CONTENT_ID])
                                ->andWhere(['name' => $row->column24])
                                ->one()
                            ;

                            if (!$brand)
                            {
                                $brand = new CmsContentElement();
                                $brand->name = $row->column24;
                                $brand->content_id = self::BRANDS_CONTENT_ID;
                                $brand->save();
                            }

                            if ($brand && !$brand->isNewRecord)
                            {
                                $cmsContentElement->relatedPropertiesModel->setAttribute('brand', $brand->id);
                            }
                        }


                        //Раздела
                        if ($row->column1)
                        {
                            $cmsTree = CmsTree::find()

                                ->joinWith('relatedElementProperties map')
                                ->joinWith('relatedElementProperties.property property')

                                ->andWhere(['property.code'     => 'stockSaleId'])
                                ->andWhere(['map.value'         => $row->column1])

                                ->joinWith('treeType as ttype')
                                ->andWhere(['ttype.code'        => 'catalog'])

                                ->one()
                            ;


                            if ($cmsTree)
                            {
                                $cmsContentElement->tree_id = $cmsTree->id;
                                if (!$cmsContentElement->save())
                                {
                                    \Yii::error($cmsContentElement->id.' not save : ' . implode(',', $cmsContentElement->getFirstErrors()), 'import');
                                }
                            }
                        }

                        //Главное изображение если еще не задано изображения
                        if ($row->column36 && !$cmsContentElement->image)
                        {
                            try
                            {
                                $realUrl = self::getAbsoluteImageSrc($row->column36);
                                $file = \Yii::$app->storage->upload($realUrl, [
                                    'name' => $cmsContentElement->name
                                ]);

                                $cmsContentElement->link('image', $file);

                            } catch (\Exception $e)
                            {
                                \Yii::error('Not upload image to: ' . $cmsContentElement->id . " ({$realUrl})", 'import');
                            }
                        }


                        //Дополнительные изображения
                        if ($row->getAdditionalImages() && !$cmsContentElement->images)
                        {
                            foreach ($row->getAdditionalImages() as $realUrl)
                            {
                                try
                                {
                                    $file = \Yii::$app->storage->upload($realUrl, [
                                        'name' => $cmsContentElement->name
                                    ]);

                                    $cmsContentElement->link('images', $file);

                                } catch (\Exception $e)
                                {
                                    \Yii::error('Not upload additional image to: ' . $cmsContentElement->id . " ({$realUrl})", 'import');
                                }
                            }
                        }

                        $cmsContentElement->relatedPropertiesModel->save();
                    }

                } else if ($row->isOffer())
                {
                    $cmsContentElement = $row->getCmsContentElementOffer();
                    if ($cmsContentElement)
                    {
                        $shopProduct = $cmsContentElement->shopProduct;

                        if (!$shopProduct)
                        {
                            $shopProduct = new ShopProduct();
                            $shopProduct->id = $cmsContentElement->id;
                            $shopProduct->save();
                        }

                        if ($shopProduct)
                        {
                            $shopProduct->baseProductPriceValue = $row->column17;
                            $shopProduct->baseProductPriceCurrency = "RUB";
                            $shopProduct->quantity = $row->column68;

                            $shopProduct->save();
                        }




                        //Размер
                        if ($row->column60)
                        {
                            if ($property = $cmsContentElement->relatedPropertiesModel->getRelatedProperty('size'))
                            {
                                if ( $enum = $property->getEnums()->andWhere(['value' => $row->column60])->one() )
                                {

                                } else
                                {
                                    $enum = new CmsContentPropertyEnum();
                                    $enum->value = $row->column60;
                                    $enum->property_id = $property->id;
                                    $enum->save();
                                }

                                if ($enum && !$enum->isNewRecord)
                                {
                                    $cmsContentElement->relatedPropertiesModel->setAttribute('size', $enum->id);
                                }
                            }
                        }


                        //Цвет
                        if ($row->column61)
                        {
                            $brand = CmsContentElement::find()
                                ->where(['content_id' => self::COLORS_CONTENT_ID])
                                ->andWhere(['name' => $row->column61])
                                ->one()
                            ;

                            if (!$brand)
                            {
                                $brand = new CmsContentElement();
                                $brand->name = $row->column61;
                                $brand->content_id = self::COLORS_CONTENT_ID;
                                $brand->save();
                            }

                            if ($brand && !$brand->isNewRecord)
                            {
                                $cmsContentElement->relatedPropertiesModel->setAttribute('color', $brand->id);
                            }
                        }

                    }

                    $cmsContentElement->relatedPropertiesModel->save();
                }
            }
        }
        fclose($handle);


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