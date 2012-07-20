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
        ImagesHolderModule::getInstance()->deleteHolder($this);
        return parent::delete();
    }
}