<?php
/**
 * @project  Investment Deals
 * @copyright © 2017 by ivoglent
 * @author ivoglent
 * @time  9/7/17.
 *
 * @var \ivoglent\media\manager\models\Media $model
 */
$attributes = '';
foreach ($model->getAttributes() as $name => $value) {
    $value = urlencode($value);
    $attributes .= (" data-{$name}='{$value}' ");
}
$attributes .= (" data-url='" . $model->getUrl() . "' ");
$attributes .= (" data-thumburl='" . $model->getUrl($model->thumb) . "' ");
?>
<div class="yii2-media-item" <?=$attributes?>>
    <div class="image">
        <img title="<?= $model->name?>" alt="<?= $model->name?>" src="<?=$model->getThumbnail()?>" />
    </div>
    <div class="info" alt="<?= $model->name?>" title="<?= $model->name?>">
        <h5><?= $model->name?></h5>
        <small><?php echo $model->getTypeName()?></small>
        <small><?php echo $model->getReadableSize()?></small>
    </div>
</div>
