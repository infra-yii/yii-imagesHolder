<?php

Yii::import('imagesHolder.models._base.BaseHeldImage');

class HeldImage extends BaseHeldImage
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getSrc($size)
    {
        return "/".$this->getFilePath($size);
    }

    public function delete()
    {
        $params = $this->holder->getModuleParams();

        foreach (array_keys($params["sizes"]) as $size) {
            if (is_file($this->getFilePath($size))) {
                unlink($this->getFilePath($size));
            }
        }
        return parent::delete();
    }

    /**
     * @private
     */
    public function updateImageFromPost() {
        if (isset($_POST["image_{$this->id}_remove"])) {
            $this->delete();
            return;
        }

        $f = CUploadedFile::getInstanceByName("image_" . $this->id . "_file");
        if ($f) {
            $this->setImageFile($f->tempName, $f->extensionName);
        }

        if (isset($_POST["image_{$this->id}_title"])) {
            if ($this->title == $_POST["image_{$this->id}_title"]) return;
            $this->title = $_POST["image_{$this->id}_title"];
            $this->save();
        }
    }

    /**
     * @private
     */
    public function setImageFile($filename, $ext) {
        /* @var $imagine ImagineYii */
        $imagine = Yii::app()->imagine;

        $params = $this->holder->getModuleParams();
        $basedir = $this->getBaseDir();
        if (!is_dir($basedir)) mkdir($basedir, 0777, true);

        $this->ext = $ext == "jpeg" ? "jpg" : $ext;

        foreach ($params["sizes"] as $size => $info) {
            if (!is_dir($basedir . "/" . $size)) {
                mkdir($basedir . "/" . $size);
            }

            if ($info) {
                list($w, $h) = explode("x", $info, 2);
                $op = "resize";
                if (strpos($h, " ")) {
                    list($h, $op) = explode(" ", $h, 2);
                }

                if ($op == "crop") {
                    $im = $imagine->crop($filename, $w, $h);
                } else if ($op == "thumb") {
                    $im = $imagine->thumb($filename, $w, $h);
                } else {
                    $im = $imagine->resize($filename, $w, $h);
                }
                $im->save($this->getFilePath($size));
            } else {
                copy($filename, $this->getFilePath($size));
            }
        }
    }

    private function getBaseDir()
    {
        static $rootDir = null;
        if(!$rootDir) {
            $rootDir = $this->getModule()->rootDir;
        }
        return $rootDir . "/" . $this->holder->type;
    }

    private function getFilePath($size)
    {
        return $this->getBaseDir() . "/" . $size . "/" . $this->id . "." . $this->ext;
    }

    /**
     * @return ImagesHolderModule
     */
    private function getModule() {
        return Yii::app()->getModule("imagesHolder");
    }
}