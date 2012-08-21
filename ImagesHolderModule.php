<?php

class ImagesHolderModule extends CWebModule
{

    public $types = Array();
    public $rootDir = "assets";
    public $ext = "jpg";

    public function init()
    {
        $this->setImport(array(
            'imagesHolder.models.*',
        ));
    }

    /**
     * @deprecated
     * @param ImagesHolderModel $model
     */
    public function saveModel(ImagesHolderModel $model)
    {
        Yii::log("Calling to ImagesHolderModule::saveModel() is deprecated. Use ImagesHolderBehaviour instead", CLogger::LEVEL_WARNING);
    }

    public function getParamsByType($type)
    {
        return $this->types[$type];
    }
}
