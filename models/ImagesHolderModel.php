<?php
/**
 * @author alari
 * @since 8/16/12 12:59 PM
 */
interface ImagesHolderModel
{
    /**
     * @abstract
     * @return array
     */
    public function imageHolders();

    public function save($runValidation=true,$attributes=null);

    public function tableName();
}
