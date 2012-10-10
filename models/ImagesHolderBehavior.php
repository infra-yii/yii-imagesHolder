<?php
/**
 * @author alari
 * @since 8/21/12 3:16 PM
 */
class ImagesHolderBehavior extends CActiveRecordBehavior implements IFormMixinBehavior
{
    public $editViews = array();
    
    public function afterSave($event) {
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

    public function onFormInit(ExtForm $form) {
        $form->htmlOptions["enctype"] = 'multipart/form-data';
    }

    public function beforeFormEnd(ExtForm $form)
    {
    }

    public function formInjectInside(ExtForm $form)
    {
        if($form->model instanceof ImagesHolderModel) {
            /** @var $model ImagesHolderModel */
            $model = $form->model;
            $imageHolders = array();
            foreach($model->imageHolders() as $h=>$t) {
                $h = str_replace(" ", "", ucwords(str_replace("_", " ", substr($h, 0, -3))));
                $h[0] = strtolower($h[0]);
                $imageHolders[$h] = $t;
            }
            if(count($imageHolders)){
                ?>
            <fieldset>
                <?
                foreach($imageHolders as $field=>$type) {
                    $widgetParams = array("holder"=>(($model && $model->$field) ? $model->$field : $type));
                    if(array_key_exists($field, $this->editViews)) {
                        $widgetParams["view"] = $this->editViews[$field];
                    }
                    Yii::app()->controller->widget("imagesHolder.widgets.heldImages.EditImages", $widgetParams);
                }?>
            </fieldset>
            <?}
        } else {
            echo "You have to implement ImagesHolderModel on your model class";
        }
    }
}
