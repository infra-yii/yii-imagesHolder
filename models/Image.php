<?php

Yii::import('imagesHolder.models._base.BaseImage');

class Image extends BaseImage
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getSrc($size)
    {
        ImagesHolderModule::getInstance()->getSrc($this, $size);
    }

    public function delete()
    {
        ImagesHolderModule::getInstance()->deleteImage($this);
        return parent::delete();
    }
}