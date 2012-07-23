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

    public function setImages(ImagesHolder $holder)
    {
        // update old images
        foreach ($holder->images as $im) {
            $this->updateImageFromPost($im);
        }

        // set new ones
        $maxNewNum = $this->getMaxNewNum($holder);

        for ($i = 0; $i < $maxNewNum; $i++) {
            $f = CUploadedFile::getInstanceByName("image_add_" . $holder->type . "_" . $i);
            if (!$f) {
                continue;
            }

            $title = $_POST["image_add_title_{$holder->type}_$i"];
            if (!$title) {
                $title = $f->name;
            }

            $im = new HeldImage();
            $im->holder_id = $holder->id;
            $im->title = $title;
            if ($im->save()) {
                $this->setImageFile($im, $f->tempName);
            }
        }
    }

    private function updateImageFromPost(HeldImage $im)
    {
        if (isset($_POST["image_{$im->id}_remove"])) {
            $im->delete();
            return;
        }

        $f = CUploadedFile::getInstanceByName("image_" . $im->id . "_file");
        if ($f) {
            $this->setImageFile($im, $f->tempName);
        }

        if (isset($_POST["image_{$im->id}_title"])) {
            if ($im->title == $_POST["image_{$im->id}_title"]) return;
            $im->title = $_POST["image_{$im->id}_title"];
            $im->save();
        }
    }

    public function setImageFile(HeldImage $image, $filename)
    {
        if (!$image->id) {
            throw new Exception("Cannot set image file to unsaved domain");
        }

        $im = Yii::app()->image->load($filename);

        $params = $this->getParamsByHolder($image->holder);
        $basedir = $this->getBaseDir($image->holder);
        if (!is_dir($basedir)) mkdir($basedir);

        foreach ($params["sizes"] as $size => $info) {
            if (!is_dir($basedir . "/" . $size)) {
                mkdir($basedir . "/" . $size);
            }

            $tmp = clone $im;
            list($w, $h) = explode("x", $info, 2);

            $tmp->resize($w, $h);

            $tmp->save($this->getFilePath($image, $size));
        }
    }

    public function deleteImage(HeldImage $image)
    {
        $params = $this->getParamsByHolder($image->holder);

        foreach (array_keys($params["sizes"]) as $size) {
            if (is_file($this->getFilePath($image, $size))) {
                unlink($this->getFilePath($image, $size));
            }
        }
    }

    public function deleteHolder(ImagesHolder $holder)
    {
        foreach ($holder->images as $im) $im->delete();
    }

    private function getBaseDir(ImagesHolder $holder)
    {
        return $this->rootDir . "/" . $holder->type;
    }

    public function getParamsByType($type)
    {
        return $this->types[$type];
    }

    public function getParamsByHolder(ImagesHolder $holder)
    {
        return $this->getParamsByType($holder->type);
    }

    public function getSrc(HeldImage $image, $size)
    {
        return "/" . $this->getFilePath($image, $size);
    }

    public function getMaxNewNum($holder, $type=null)
    {
        if(!$holder) {
            $params = $this->getParamsByType($type);
            return $params["maxNum"] ? $params["maxNum"] : 5;
        }
        $params = $this->getParamsByHolder($holder);
        $maxNum = $params["maxNum"];

        if (!$maxNum) return 5;
        else return $maxNum - count($holder->images);
    }

    private function getFilePath(HeldImage $image, $size)
    {
        return $this->getBaseDir($image->holder) . "/" . $size . "/" . $image->id . "." . $this->ext;
    }
}
