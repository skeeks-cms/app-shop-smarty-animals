<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (ÑêèêÑ)
 * @date 01.10.2015
 */
namespace common\models;
use skeeks\cms\helpers\CmsContentElementHelper;
use skeeks\cms\models\CmsContentElement;

/**
 * @property CmsContentElement $brand
 * @property string $article
 * Class User
 * @package common\models
 */
class Product
    extends CmsContentElementHelper
{
    public function getArticle()
    {
        return (string) $this->model->relatedPropertiesModel->getAttribute('article');
    }

    /**
     * @return CmsContentElement
     */
    public function getBrand()
    {
        return CmsContentElement::findOne((int) $this->model->relatedPropertiesModel->getAttribute('brand'));
    }

    public function getCharacters()
    {
        return $this->model->relatedPropertiesModel->getAttribute('characters');
    }
    public function getTextUnderBasket()
    {
        return $this->model->relatedPropertiesModel->getAttribute('textUnderBasket');
    }
}