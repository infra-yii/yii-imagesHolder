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

    public function saveModel(ImagesHolderModel $model)
    {
        $holdersCreated = array();
        foreach ($model->imageHolders() as $field => $type) {
            if (!$model->$field || !ImagesHolder::model()->findByPk($model->$field)) {
                $holder = new ImagesHolder();
                $holder->type = $type;
                $holder->save();
                $holdersCreated[$field] = $holder->id;
            }
        }
        if (count($holdersCreated)) {
            Yii::app()->db->createCommand()->update($model->tableName(), $holdersCreated, "id=" . $model->id);
        }
        foreach ($model->imageHolders() as $field => $type) {
            $holder = ImagesHolder::model()->findByPk($model->$field ? : $holdersCreated[$field]);
            if ($holder) $holder->setImagesFromPost();
        }
    }

    public function getParamsByType($type)
    {
        return $this->types[$type];
    }
}
