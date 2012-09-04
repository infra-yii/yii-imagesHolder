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
        foreach ($this->images as $im) $im->delete();
        return parent::delete();
    }

    /**
     * @private
     */
    public function setImagesFromPost() {
        // update old images
        foreach ($this->images as $im) {
            $im->updateImageFromPost();
        }

        // set new ones
        $maxNewNum = $this->getMaxNewImages();

        for ($i = 0; $i < $maxNewNum; $i++) {
            $f = CUploadedFile::getInstanceByName("image_add_" . $this->type . "_" . $i);
            if (!$f) {
                continue;
            }

            $title = $_POST["image_add_title_{$this->type}_$i"];
            if (!$title) {
                $title = $f->name;
            }

            $im = new HeldImage();
            $im->holder_id = $this->id;
            $im->title = $title;
            if ($im->save()) {
                $im->setImageFile($f->tempName, $f->extensionName);
                $im->save();
            }
        }
    }

    /**
     * @private
     * @return int
     */
    public function getMaxNewImages() {
        $params = $this->getModuleParams();
        $maxNum = $params["maxNum"];

        if (!$maxNum) return 5;
        else return $maxNum - count($this->images);
    }

    /**
     * @private
     */
    public function getModuleParams() {
        return $this->getModule()->getParamsByType($this->type);
    }

    /**
     * @return ImagesHolderModule
     */
    private function getModule() {
        return Yii::app()->getModule("imagesHolder");
    }
}