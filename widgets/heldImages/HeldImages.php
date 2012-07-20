<?php
/**
 * Created by IntelliJ IDEA.
 * User: alari
 * Date: 7/16/12
 * Time: 6:23 PM
 * To change this template use File | Settings | File Templates.
 */
class HeldImages extends CWidget
{
    public $holder;
    public $size;

    public function run()
    {
        if (!$this->size) {
            $this->size = Yii::app()->getModule("imagesHolder")->getParamsByHolder($this->holder);
            $this->size = $this->size["default"];
        }
        $this->render("heldImages", array(
            "images" => $this->holder->images,
            "size" => $this->size
        ));
    }
}
