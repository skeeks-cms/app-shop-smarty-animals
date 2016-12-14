<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (ÑêèêÑ)
 * @date 25.05.2015
 */
namespace common\widgets\filters;

use skeeks\cms\base\WidgetRenderable;
use skeeks\cms\components\Cms;
use skeeks\cms\models\CmsContent;
use skeeks\cms\shop\cmsWidgets\filters\models\SearchRelatedPropertiesModel;
use skeeks\cms\shop\models\ShopTypePrice;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
/**
 * @property ShopTypePrice      $typePrice;
 * @property CmsContent         $cmsContent;
 *
 * Class ShopProductFiltersWidget
 * @package skeeks\cms\shop\cmsWidgets\filters
 */
class SearchProductsModel extends Model
{
    /**
     * @var SearchRelatedPropertiesModel
     */
    public $relatedProperties;

    public $image;

    public $price_from;
    public $price_to;
    public $type_price_id;

    public $hasQuantity;


    public $brands;

    public function rules()
    {
        return [
            [['image'], 'string'],

            [['price_from'], 'number'],
            [['price_to'], 'number'],
            [['type_price_id'], 'number'],
            [['hasQuantity'], 'boolean'],
            [['brands'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'image' => \Yii::t('app', 'With photo'),
            'price_from' => \Yii::t('app', 'Price from'),
            'price_to' => \Yii::t('app', 'Price to1'),
            'type_price_id' => \Yii::t('app', 'Price type'),
            'hasQuantity' => \Yii::t('app', 'In stock'),
            'brands' => "Áðýíä"
        ];
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     * @throws \yii\base\InvalidConfigException
     */
    public function search(ActiveDataProvider $dataProvider)
    {
        $query = $dataProvider->query;

        if ($this->image == Cms::BOOL_Y)
        {
            $query->andWhere([
                'or',
                ['!=', 'cms_content_element.image_id', null],
                ['!=', 'cms_content_element.image_id', ""],
            ]);
        } else if ($this->image == Cms::BOOL_N)
        {
            $query->andWhere([
                'or',
                ['cms_content_element.image_id' => null],
                ['cms_content_element.image_id' => ""],
            ]);
        }

        $query->leftJoin('shop_product', '`shop_product`.`id` = `cms_content_element`.`id`');

        if ($this->type_price_id)
        {

            $query->leftJoin('shop_product_price', '`shop_product_price`.`product_id` = `shop_product`.`id`');
            $query->leftJoin('money_currency', '`money_currency`.`code` = `shop_product_price`.`currency_code`');

            $query->select(['cms_content_element.*', 'realPrice' => '( (SELECT course FROM `money_currency` WHERE `money_currency`.`code` = `shop_product_price`.`currency_code`) * `shop_product_price`.`price` )']);

            $query->andWhere(['shop_product_price.type_price_id' => $this->type_price_id]);

            if ($this->price_to)
            {
                $query->andHaving(['<=', 'realPrice', $this->price_to]);
            }
            if ($this->price_from)
            {
                $query->andHaving(['>=', 'realPrice', $this->price_from]);
            }
        }

        if ($this->hasQuantity)
        {
            $query->andWhere(['>', 'shop_product.quantity', 0]);
        }


        return $dataProvider;
    }
}