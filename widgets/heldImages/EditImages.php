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
    /* @var ImagesHolder */
    public $holder;

    public function run()
    {
        if(is_string($this->holder)) {
            $t = $this->holder;
            $this->holder = new ImagesHolder();
            $this->holder->type = $t;
        }

        // We need maxNum and preview size name to render edit
        $maxNum = $this->holder->getMaxNewImages();
        $params = $this->holder->getModuleParams();
        $previewSize = $params["preview"];

        $images = array();
        if ($this->holder) {
            $images = $this->holder->images;
        }

        $this->render("editImages", array(
            "type" => $this->holder->type,
            "images" => $images,
            "maxNum" => $maxNum,
            "preview" => $previewSize
        ));
    }
}
