<?php
/**
 * @author alari
 * @since 8/21/12 3:16 PM
 */
class ImagesHolderBehavior extends CActiveRecordBehavior
{
    public function afterSave(CModelEvent $event) {
        /* @var $model ImagesHolderModel */
        $model = $this->owner;
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
}
