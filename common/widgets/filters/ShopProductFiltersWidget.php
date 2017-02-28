<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 25.05.2015
 */
namespace common\widgets\filters;

use skeeks\cms\base\WidgetRenderable;
use skeeks\cms\models\CmsContent;
use skeeks\cms\shop\cmsWidgets\filters\models\SearchRelatedPropertiesModel;
use skeeks\cms\shop\models\ShopTypePrice;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
/**
 * @property ShopTypePrice      $typePrice;
 * @property CmsContent         $cmsContent;
 *
 * Class ShopProductFiltersWidget
 * @package skeeks\cms\shop\cmsWidgets\filters
 */
class ShopProductFiltersWidget extends WidgetRenderable
{
    //Навигация
    public $content_id;
    public $searchModelAttributes       = [];

    public $realatedProperties          = [];
    public $type_price_id               = "";

    /**
     * @var \skeeks\cms\shop\cmsWidgets\filters\models\SearchProductsModel
     */
    public $searchModel                 = null;


    /**
     * @var SearchRelatedPropertiesModel
     */
    public $searchRelatedPropertiesModel  = null;

    static public function descriptorConfig()
    {
        return array_merge(parent::descriptorConfig(), [
            'name'          => 'Фильтры',
        ]);
    }

    public function init()
    {
        parent::init();

        if (!$this->searchRelatedPropertiesModel)
        {
            $this->searchRelatedPropertiesModel = new SearchRelatedPropertiesModel();
            if ($this->cmsContent)
            {
                $this->searchRelatedPropertiesModel->initCmsContent($this->cmsContent);
            }
        }

        if (!$this->searchModel)
        {
            $this->searchModel = new \common\widgets\filters\SearchProductsModel([
                'relatedProperties' => $this->searchRelatedPropertiesModel
            ]);
        }



        //$this->searchModel->load(\Yii::$app->request->get());
        //$this->searchRelatedPropertiesModel->load(\Yii::$app->request->get());
    }




    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(),
        [
            'content_id'                => \skeeks\cms\shop\Module::t('app', 'Content'),
            'searchModelAttributes'     => \skeeks\cms\shop\Module::t('app', 'Fields'),
            'realatedProperties'        => \skeeks\cms\shop\Module::t('app', 'Properties'),
            'type_price_id'             => \skeeks\cms\shop\Module::t('app', 'Types of prices'),
        ]);
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(),
        [
            [['content_id'], 'integer'],
            [['searchModelAttributes'], 'safe'],
            [['realatedProperties'], 'safe'],
            [['type_price_id'], 'integer'],
        ]);
    }

    /**
     * @return ShopTypePrice
     */
    public function getTypePrice()
    {
        if (!$this->type_price_id)
        {
            return null;
        }
        return ShopTypePrice::find()->where(['id' => $this->type_price_id])->one();
    }

    /**
     * @return CmsContent
     */
    public function getCmsContent()
    {
        return CmsContent::findOne($this->content_id);
    }

    /**
     * @param ActiveDataProvider $activeDataProvider
     */
    public function search(ActiveDataProvider $activeDataProvider)
    {
        $this->searchModel->search($activeDataProvider);
        //$this->searchRelatedPropertiesModel->search($activeDataProvider);
    }
}