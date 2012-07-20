<? foreach ($images as $im) { ?>
<div class="row">
    <?=CHtml::image($im->getSrc($preview))?>
    <?=CHtml::textField("image_" . $im->id . "_title", $im->title)?>
    <?=CHtml::fileField("image_" . $im->id . "_file", $im->title)?>
    <?=CHtml::checkBox("image_" . $im->id . "_remove")?> &ndash; <?=Yii::t("app", "Remove image")?>
</div>
<? } ?>
<? for ($i = 0; $i < $maxNum; $i++) { ?>
<div class="row">
    <?=CHtml::fileField("image_add_{$type}_$i")?>
    <?=CHtml::textField("image_add_title_{$type}_$i")?>
</div>
<? } ?>