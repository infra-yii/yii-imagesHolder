<? if (count($images)) { ?>
<ul>
    <?foreach ($images as $im) { ?>
    <li class="feature-item">
        <?=CHtml::image($im->getSrc($size))?>
        <?=$im->title?>
    </li>
    <? }?>
</ul>
<? } ?>