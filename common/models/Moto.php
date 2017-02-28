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
 * @property CmsContentElement $type
 * @property CmsContentElement $marka
 * @property int $volume
 * @property int $mileage
 * @property int $year
 * @property string $color
 * @property string $vin
 * @property float $reviewsRating
 * @property int $reviewsCount
 * @property bool $isAbs
 *
 */
class Moto
    extends CmsContentElementHelper
{
    public function getType()
    {
        return CmsContentElement::findOne((int) $this->model->relatedPropertiesModel->getAttribute('type'));
    }

    /**
     * @return CmsContentElement
     */
    public function getMarka()
    {
        return CmsContentElement::findOne((int) $this->model->relatedPropertiesModel->getAttribute('marka'));
    }

    /**
     * @return int
     */
    public function getVolume()
    {
        return (int) $this->model->relatedPropertiesModel->getAttribute('volume');
    }

    /**
     * @return int
     */
    public function getMileage()
    {
        $val = $this->model->relatedPropertiesModel->getAttribute('mileage');
        $val = str_replace(" ", "", $val);
        return (int) $val;
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return (int) $this->model->relatedPropertiesModel->getAttribute('year');
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return (string) $this->model->relatedPropertiesModel->getAttribute('color');
    }

    /**
     * @return string
     */
    public function getVin()
    {
        return (string) $this->model->relatedPropertiesModel->getAttribute('vin');
    }

    /**
     * @return float
     */
    public function getReviewsRating()
    {
        return (float) $this->model->relatedPropertiesModel->getAttribute('reviews2_rating');
    }

    /**
     * @return bool
     */
    public function getIsAbs()
    {
        $enum = $this->model->relatedPropertiesModel->getEnumByAttribute('abs');
        return (bool) ($enum->code == "Y");
    }

    /**
     * @return float
     */
    public function getReviewsCount()
    {
        return (int) $this->model->relatedPropertiesModel->getAttribute('reviews2_count');
    }
}