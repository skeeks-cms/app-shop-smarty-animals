<?php
/**
 * Thumbnail
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010-2014 SkeekS (Sx)
 * @date 11.12.2014
 * @since 1.0.0
 */

namespace common\thumbnails;
use Imagine\Image\Point;
use yii\base\Component;
use skeeks\imagine\Image;
use Imagine\Image\ManipulatorInterface;
use yii\base\Exception;

/**
 * Class Thumbnail
 * @package skeeks\cms\components\imaging\filters
 */
class MediumWatermark extends \skeeks\cms\components\imaging\Filter
{
    public $w       = 1200;

    public function init()
    {
        parent::init();

        if (!$this->w)
        {
            throw new Exception("Необходимо указать ширину или высоту");
        }
    }

    protected function _save()
    {
        $watermarkImage = Image::getImagine()->open(\Yii::getAlias("@webroot/img/watermarks/watermark.png"));
        $originalImage = Image::getImagine()->open($this->_originalRootFilePath);
        //Ресайз оригинала
        if ($originalImage->getSize()->getWidth() > $this->w)
        {
            $originalImage->resize($originalImage->getSize()->widen($this->w));
        }

        //Подстроим вотермарк
        $imageHeight        = $originalImage->getSize()->getHeight();
        $newWatermarkHeight = round($imageHeight / 10);
        $watermarkImage->resize($watermarkImage->getSize()->heighten($newWatermarkHeight));

        //Наметим точки куда будем клеить водяные знаки
        $size      = $originalImage->getSize();
        $wSize     = $watermarkImage->getSize();
        $bottomRight    = new Point($size->getWidth() - $wSize->getWidth(), $size->getHeight() - $wSize->getHeight());

        $originalImage
            ->paste($watermarkImage, $bottomRight);

        $originalImage->save($this->_newRootFilePath);
    }
}