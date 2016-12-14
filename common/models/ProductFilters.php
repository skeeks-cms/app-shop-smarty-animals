<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 08.04.2016
 */
namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class ProductFilters extends Model
{
    public $sort = "-popular";
    public $inStock = 0;

    public function rules()
    {
        return [
            ['sort', 'string'],
            ['inStock', 'integer'],
        ];
    }

    public function init()
    {
        parent::init();
    }

    public function attributeLabels()
    {
        return [];
    }

    public function search(ActiveDataProvider $activeDataProvider)
    {
        $query = $activeDataProvider->query;

        /**
         * @var $query \yii\db\ActiveQuery
         */


        if ($this->sort)
        {
            switch($this->sort)
            {
                case ('-sort'):
                    $query->orderBy(['priority' => SORT_DESC]);
                    break;

                case ('-popular'):
                    $query->orderBy(['show_counter' => SORT_DESC]);
                    break;

                case ('-published_at'):
                    $query->orderBy(['published_at' => SORT_DESC]);
                    break;

                case ('price'):
                    /*$query->joinWith('shopProduct.baseProductPrice as basePrice');
                    $query->orderBy(['baseProductPrice.price' => SORT_ASC]);*/

                    $joined = [];
                    if ($query->join)
                    {
                        $joined = (array) ArrayHelper::map($query->join, 1, 1);
                    }


                    if (ArrayHelper::getValue($joined, 'shop_product_price'))
                    {
                        $query->orderBy(['shop_product_price.price' => SORT_ASC]);
                    } else if (ArrayHelper::getValue($joined, 'shop_product'))
                    {
                        $query->leftJoin('shop_product_price', '`shop_product_price`.`product_id` = `shop_product`.`id`');
                        $query->orderBy(['shop_product_price.price' => SORT_ASC]);
                    } else
                    {
                        $query->joinWith('shopProduct.baseProductPrice as basePrice');
                        $query->orderBy(['basePrice.price' => SORT_ASC]);
                    }


                    break;

                case ('-price'):
                    /*$query->joinWith('shopProduct.baseProductPrice as basePrice');
                    $query->orderBy(['baseProductPrice.price' => SORT_DESC]);*/
                    $joined = [];
                    if ($query->join)
                    {
                        $joined = (array) ArrayHelper::map($query->join, 1, 1);
                    }

                    if (ArrayHelper::getValue($joined, 'shop_product_price'))
                    {
                        $query->orderBy(['shop_product_price.price' => SORT_DESC]);
                    } else if (ArrayHelper::getValue($joined, 'shop_product'))
                    {
                        $query->leftJoin('shop_product_price', '`shop_product_price`.`product_id` = `shop_product`.`id`');
                        $query->orderBy(['shop_product_price.price' => SORT_DESC]);
                    } else
                    {
                        $query->joinWith('shopProduct.baseProductPrice as basePrice');
                        $query->orderBy(['basePrice.price' => SORT_DESC]);
                    }


                    break;
            }
        }

        if ($this->inStock  == 1)
        {
            $query->joinWith('shopProduct as shopProduct');
            $query->andWhere(['>=', 'shopProduct.quantity', 1]);
        }

        return $this;
    }

}
