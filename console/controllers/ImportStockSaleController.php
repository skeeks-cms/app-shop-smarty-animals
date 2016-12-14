<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 28.03.2016
 */
namespace console\controllers;

use common\models\ImportStockSaleV2;
use common\models\stockSale\StockSaleV2RowModel;
use skeeks\cms\helpers\FileHelper;
use skeeks\cms\models\CmsContentElement;
use skeeks\cms\models\CmsContentPropertyEnum;
use skeeks\cms\models\CmsLang;
use skeeks\cms\models\CmsTree;
use skeeks\cms\shop\models\ShopProduct;
use yii\base\Exception;
use yii\helpers\Console;

/**
 * Class ImportStockSaleController
 * @package console\controllers
 */
class ImportStockSaleController extends \yii\console\Controller
{


    /**
     * RemoveProducts
     */
    public function actionRemoveProducts()
    {
        ini_set('memory_limit', '500M');

        return;
        try
        {
            $find = \skeeks\cms\models\CmsContentElement::find()

            ->joinWith('relatedElementProperties map')
            ->joinWith('relatedElementProperties.property property')

            ->joinWith('cmsContent as ccontent')
            ->andWhere(['ccontent.code' => 'product'])
            ->groupBy(['cms_content_element.id'])
            //->limit(1000)

            ;

            //$this->stdout("All found products: " . $find->count() . "\n");

            foreach ($find->all() as $cmsContentElement)
            {
                /**
                 * @var $cmsContentElement CmsContentElement
                 */

                if ($cmsContentElement->delete())
                {
                     $this->stdout("\tDeleted: " . $cmsContentElement->id . "\n", Console::FG_GREEN);
                } else
                {
                    throw new Exception("Not deleted: " . $cmsContentElement->id);
                }
            }
            /*
            if ($apiLangs = $result->offsetGet('data')['languages'])
            {
                foreach ($apiLangs as $dataLang)
                {
                    $cmsLang = CmsLang::find()->where(['code' => $dataLang['language']])->one();
                    if (!$cmsLang)
                    {
                        $cmsLang = new CmsLang([
                            'code' => $dataLang['language'],
                        ]);
                    }

                    $cmsLang->name = $dataLang['name'];
                    $cmsLang->save();
                    $this->stdout("\t" . $dataLang['language'] . " - " . $dataLang['name'] . "\n");
                }
            } else
            {
                $this->stdout('Not found langs in api', Console::FG_RED);
            }*/
        } catch (\Exception $e)
        {
            $this->stdout($e->getMessage(), Console::FG_RED);
        }


    }

    /**
     * @var ImportStockSaleV2
     */
    public $importStockSale = null;

    public function beforeAction($action)
    {
        ini_set('memory_limit', '500M');

        if (parent::beforeAction($action))
        {
            if (!\Yii::$app->settings->stockSaleCSVUrl)
            {
                $this->stdout("\tNot found csv file in settings\n", Console::FG_RED);
                return false;
            }

            $downloadingFile = \Yii::$app->settings->stockSaleCSVUrl;
            $this->stdout("\tDownloading file: {$downloadingFile}\n", Console::FG_YELLOW);

            $content = file_get_contents(\Yii::$app->settings->stockSaleCSVUrl);
            $tmpDir = \Yii::getAlias('@runtime/tmp/import/' . date("Y-m-d"));

            if (!$content)
            {
                $this->stdout("\tNot found download conntent\n", Console::FG_RED);
                return false;
            }

            if (!FileHelper::createDirectory($tmpDir))
            {
                $this->stdout("\tNot created tmp dir\n", Console::FG_RED);
                return false;
            }

            $file = $tmpDir . "/import-" . time() . ".csv";
            // открываем файл, если файл не существует,
            //делается попытка создать его
            $fp = fopen($file, "w");
            // записываем в файл текст
            fwrite($fp, $content);
            // закрываем
            fclose($fp);


            $this->importStockSale = new ImportStockSaleV2([
                'rootPath' => $file
            ]);

            $this->stdout("File importing: {$this->importStockSale->rootPath}\n", Console::BOLD);

            if ($this->importStockSale->countRows() > 0)
            {
                $this->stdout("\tFound csv rows: {$this->importStockSale->countRows()}\n", Console::FG_GREEN);
                return true;
            } else
            {
                $this->stdout("\tNot found csv rows\n", Console::FG_RED);
                return false;
            }
        }
    }

    /**
     * Import all
     */
    public function actionTest()
    {
        $file = __DIR__ . '/ImportStockSaleController.php';
        $content = file_get_contents($file);
        for($i =0; $i <= 5; $i ++)
        {
            $content = $content . $content;
        }

        $this->stdout($content);
    }

    /**
     * Import all
     */
    public function actionAll()
    {
        $this->actionSections();
        $this->actionProducts();
    }
    /**
     * Importing sections
     */
    public function actionSections()
    {
        $counter = 0;

        $handle = fopen($this->importStockSale->rootPath, "r");

        if (!$this->importStockSale->rootTree)
        {
            $this->stdout("\tNot found catalog tree\n", Console::FG_RED);
            return false;
        }

        $count = $this->importStockSale->countRows();
        Console::startProgress(0, $count);

        while (($data = fgetcsv($handle, 0, ";")) !== FALSE)
        {
            $counter ++;

            if ($counter <= 1)
            {
                continue;
            }

            Console::updateProgress($counter, $count);

            $row = StockSaleV2RowModel::createFromCsvRow($data);

            if ($row->isTreeData())
            {
                if (!$row->column0)
                {
                    continue;
                }

                if (!$tree1 = $this->importStockSale->rootTree->getChildren()->andWhere(['name' => $row->column0])->one())
                {
                    $tree1 = new CmsTree();
                    $tree1->name = $row->column0;

                    if (!$this->importStockSale->rootTree->processAddNode($tree1))
                    {
                        $this->stdout("\tNot added tree {$tree1->name}\n", Console::FG_RED);
                        continue;
                    }

                    $this->stdout("\tAdded tree {$tree1->name}\n", Console::FG_GREEN);
                } else
                {
                    //$this->stdout("\tExist tree {$tree1->name}\n");
                }

                if (!$row->column1)
                {
                    continue;
                }

                if (!$tree2 = $tree1->getChildren()->andWhere(['name' => $row->column1])->one())
                {
                    $tree2 = new CmsTree();
                    $tree2->name = $row->column1;

                    if (!$tree1->processAddNode($tree2))
                    {
                        $this->stdout("\tNot added tree {$tree2->name}\n", Console::FG_RED);
                        continue;
                    }

                    $this->stdout("\tAdded tree {$tree2->name}\n", Console::FG_GREEN);
                } else
                {
                    //$this->stdout("\tExist tree {$tree2->name}\n");
                }


                if (!$row->column2)
                {
                    continue;
                }

                if (!$tree3 = $tree2->getChildren()->andWhere(['name' => $row->column2])->one())
                {
                    $tree3 = new CmsTree();
                    $tree3->name = $row->column2;

                    if (!$tree2->processAddNode($tree3))
                    {
                        $this->stdout("\tNot added tree {$tree3->name}\n", Console::FG_RED);
                        continue;
                    }

                    $this->stdout("\tAdded tree {$tree3->name}\n", Console::FG_GREEN);
                } else
                {
                    //$this->stdout("\tExist tree {$tree3->name}\n");
                }

            }


        }

        Console::endProgress();
    }

    private function _updateShopProduct(StockSaleV2RowModel $row, CmsContentElement $cmsContentElement)
    {
        $shopProduct = $cmsContentElement->shopProduct;

        if (!$shopProduct)
        {
            $shopProduct = new ShopProduct();
            $shopProduct->id = $cmsContentElement->id;
            $shopProduct->save();
            $this->stdout("\tadded ShopProduct\n", Console::FG_GREEN);
        } else
        {
            $this->stdout("\texist ShopProduct\n");
        }

        $allowPriceUpdate = true;

        if ($shopProduct)
        {
            if ((float) \Yii::$app->settings->marginRatio > 0)
            {
                $priceCalc = round( (float) \Yii::$app->settings->marginRatio * (float) $row->column6 );
            } else
            {
                $priceCalc = $row->column6;
            }

            if ($enum = $cmsContentElement->relatedPropertiesModel->getEnumByAttribute('priceDisallow'))
            {
                if ($enum->code == 'disallow')
                {
                    $allowPriceUpdate = false;
                }
            }

            //Есть родитель
            if ($cmsContentElement->parentContentElement)
            {
                if ($enum = $cmsContentElement->parentContentElement->relatedPropertiesModel->getEnumByAttribute('priceDisallow'))
                {
                    if ($enum->code == 'disallow')
                    {
                        $allowPriceUpdate = false;
                    }
                }
            }

            if ($allowPriceUpdate)
            {
                $shopProduct->baseProductPriceValue = $priceCalc;
                $shopProduct->baseProductPriceCurrency = "RUB";
            } else
            {
                $this->stdout("\tNot update price\n", Console::FG_YELLOW);
            }


            $shopProduct->quantity = $row->column20;
            $shopProduct->product_type = ShopProduct::TYPE_OFFERS;

            if ($shopProduct->save())
            {
                $this->stdout("\tShopProduct saved\n", Console::FG_GREEN);
            } else
            {
                $this->stdout("\tShopProduct not saved\n", Console::FG_RED);
            }
        }
    }


    /**
     * Importing sections
     */
    public function actionProducts()
    {
        $counter = 0;

        $handle = fopen($this->importStockSale->rootPath, "r");

        if (!$this->importStockSale->rootTree)
        {
            $this->stdout("\tNot found catalog tree\n", Console::FG_RED);
            return false;
        }

        $count = $this->importStockSale->countRows();
        Console::startProgress(0, $count);

        while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
            $counter++;

            if ($counter <= 1) {
                continue;
            }

            Console::updateProgress($counter, $count);

            $row = StockSaleV2RowModel::createFromCsvRow($data);
            $this->stdout($row->column3);

            if ($row->isOffer())
            {
                $this->stdout(" - offer\n");

                try
                {
                    $cmsContentElement = $row->getCmsContentElementOffer();
                } catch (\Exception $e)
                {
                    $this->stdout("\t{$e->getMessage()}'\n", Console::FG_RED);
                    continue;
                }

                if ($cmsContentElement)
                {
                    $this->stdout("\tid: {$cmsContentElement->id}\n");

                    $this->_updateShopProduct($row, $cmsContentElement);

                    //Размер
                    if ($row->column10)
                    {
                        if ($property = $cmsContentElement->relatedPropertiesModel->getRelatedProperty('size'))
                        {
                            if ( $enum = $property->getEnums()->andWhere(['value' => $row->column10])->one() )
                            {

                            } else
                            {
                                $enum = new CmsContentPropertyEnum();
                                $enum->value = $row->column10;
                                $enum->property_id = $property->id;
                                if ($enum->save())
                                {
                                    $this->stdout("\tadded size '{$row->column10}' to DB\n", Console::FG_GREEN);
                                } else
                                {
                                    $this->stdout("\tNot added size '{$row->column10}' to DB\n", Console::FG_RED);
                                }
                            }

                            if ($enum && !$enum->isNewRecord)
                            {
                                $cmsContentElement->relatedPropertiesModel->setAttribute('size', $enum->id);
                            }
                        }
                    }


                    //Цвет
                    if ($row->column9)
                    {
                        $brand = CmsContentElement::find()
                            ->where(['content_id' => ImportStockSaleV2::COLORS_CONTENT_ID])
                            ->andWhere(['name' => $row->column9])
                            ->one()
                        ;

                        if (!$brand)
                        {
                            $brand = new CmsContentElement();
                            $brand->name = $row->column9;
                            $brand->content_id = ImportStockSaleV2::COLORS_CONTENT_ID;
                            if ($brand->save())
                            {
                                $this->stdout("\tadded color '{$row->column9}'' to DB\n", Console::FG_GREEN);
                            } else
                            {
                                $this->stdout("\tNot added color '{$row->column9}' to DB\n", Console::FG_RED);
                            }
                        }

                        if ($brand && !$brand->isNewRecord)
                        {
                            $cmsContentElement->relatedPropertiesModel->setAttribute('color', $brand->id);
                        }
                    }

                    $cmsContentElement->relatedPropertiesModel->save();
                } else
                {
                    $this->stdout("\tNot found offer, xml row: '{$counter}'\n", Console::FG_RED);
                }

            } else if ($row->isProduct())
            {
                $this->stdout(" - product\n");

                try
                {
                    $cmsContentElement = $row->getCmsContentElementProduct();
                } catch (\Exception $e)
                {
                    $this->stdout("\t{$e->getMessage()}'\n", Console::FG_RED);
                    continue;
                }

                if ($cmsContentElement)
                {
                    $this->stdout("\tid: {$cmsContentElement->id}\n");

                    $this->_updateShopProduct($row, $cmsContentElement);

                    //Состав
                    if ($row->column11)
                    {
                        $cmsContentElement->relatedPropertiesModel->setAttribute('composition', $row->column11);
                    }

                    //Сезон
                    if ($row->column12)
                    {
                        if ($property = $cmsContentElement->relatedPropertiesModel->getRelatedProperty('season'))
                        {
                            if ( $enum = $property->getEnums()->andWhere(['value' => $row->column12])->one() )
                            {

                            } else
                            {
                                $enum = new CmsContentPropertyEnum();
                                $enum->value = $row->column12;
                                $enum->property_id = $property->id;
                                if ($enum->save())
                                {
                                    $this->stdout("\tadded season '{$row->column12}' to DB\n", Console::FG_GREEN);
                                } else
                                {
                                    $this->stdout("\tNot added season '{$row->column12}' to DB\n", Console::FG_RED);
                                }
                            }

                            if ($enum && !$enum->isNewRecord)
                            {
                                $cmsContentElement->relatedPropertiesModel->setAttribute('season', $enum->id);
                            }
                        }
                    }


                    //Брэнд
                    if ($row->column7)
                    {
                        $brand = CmsContentElement::find()
                            ->where(['content_id' => ImportStockSaleV2::BRANDS_CONTENT_ID])
                            ->andWhere(['name' => $row->column7])
                            ->one()
                        ;

                        if (!$brand)
                        {
                            $brand = new CmsContentElement();
                            $brand->name = $row->column7;
                            $brand->content_id = ImportStockSaleV2::BRANDS_CONTENT_ID;
                            if ($brand->save())
                            {
                                $this->stdout("\tadded brand '{$row->column7}'' to DB\n", Console::FG_GREEN);
                            } else
                            {
                                $this->stdout("\tNot added brand '{$row->column7}' to DB\n", Console::FG_RED);
                            }
                        }

                        if ($brand && !$brand->isNewRecord)
                        {
                            $cmsContentElement->relatedPropertiesModel->setAttribute('brand', $brand->id);
                        }
                    }


                    //Главное изображение если еще не задано изображения
                    if ($row->column8 && !$cmsContentElement->image)
                    {
                        try
                        {
                            $realUrl = $this->importStockSale->getAbsoluteImageSrc($row->column8);
                            $file = \Yii::$app->storage->upload($realUrl, [
                                'name' => $cmsContentElement->name
                            ]);

                            $cmsContentElement->link('image', $file);

                            $this->stdout("\tadded main image\n", Console::FG_GREEN);

                        } catch (\Exception $e)
                        {
                            $message = 'Not upload image to: ' . $cmsContentElement->id . " ({$realUrl})";
                            $this->stdout("\t{$message}\n", Console::FG_RED);
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

                                $this->stdout("\tadded additional image\n", Console::FG_GREEN);

                            } catch (\Exception $e)
                            {
                                //\Yii::error('Not upload additional image to: ' . $cmsContentElement->id . " ({$realUrl})", 'import');
                                $message = 'Not upload additional image to: ' . $cmsContentElement->id . " ({$realUrl})";
                                $this->stdout("\t{$message}\n", Console::FG_RED);
                            }
                        }
                    }


                    //Раздела
                    if ($tree = $row->getCmsTree())
                    {
                        $cmsContentElement->tree_id = $tree->id;
                        if (!$cmsContentElement->save())
                        {
                            $message = $cmsContentElement->id.' not save : ' . implode(',', $cmsContentElement->getFirstErrors());
                            $this->stdout("\t{$message}\n", Console::FG_RED);
                        } else
                        {
                            $this->stdout("\tsuccess tree\n", Console::FG_GREEN);
                        }
                    }

                    $cmsContentElement->relatedPropertiesModel->save();

                } else
                {
                    $this->stdout("\tNot found product, xml row: '{$counter}'\n", Console::FG_RED);
                }

            }
        }

        Console::endProgress();
    }



}