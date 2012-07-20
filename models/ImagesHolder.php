<?php

Yii::import('imagesHolder.models._base.BaseImagesHolder');

class ImagesHolder extends BaseImagesHolder
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function delete()
    {
        Yii::app()->getModule("imagesHolder")->deleteHolder($this);
        return parent::delete();
    }

    public function setImages() {
        Yii::app()->getModule("imagesHolder")->setImages($this);
    }
}