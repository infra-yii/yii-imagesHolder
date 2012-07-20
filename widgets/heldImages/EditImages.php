<?php
/**
 * Created by IntelliJ IDEA.
 * User: alari
 * Date: 7/16/12
 * Time: 6:25 PM
 * To change this template use File | Settings | File Templates.
 */
class EditImages extends CWidget
{
    public $type;
    public $holder;

    public function run()
    {
        // One have to be set
        if (!$this->type) {
            $this->type = $this->holder->type;
        }

        // We need maxNum and preview size name to render edit
        $maxNum = Yii::app()->getModule("imagesHolder")->getMaxNewNum($this->holder, $this->type);
        $params = Yii::app()->getModule("imagesHolder")->getParamsByType($this->type);
        $previewSize = $params["preview"];

        $images = array();
        if ($this->holder) {
            $images = $this->holder->images;
        }

        $this->render("editImages", array(
            "type" => $this->type,
            "images" => $images,
            "maxNum" => $maxNum,
            "preview" => $previewSize
        ));
    }
}
