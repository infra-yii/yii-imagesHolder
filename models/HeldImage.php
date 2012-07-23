<?php

Yii::import('imagesHolder.models._base.BaseImage');

class HeldImage extends BaseImage
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getSrc($size)
    {
        return Yii::app()->getModule("imagesHolder")->getSrc($this, $size);
    }

    public function delete()
    {
        Yii::app()->getModule("imagesHolder")->deleteImage($this);
        return parent::delete();
    }
}