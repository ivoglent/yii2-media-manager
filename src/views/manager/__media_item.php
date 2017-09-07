<?php
/**
 * @project  Investment Deals
 * @copyright © 2017 by ivoglent
 * @author ivoglent
 * @time  9/7/17.
 *
 * @var \ivoglent\media\manager\models\Media $model
 */
?>
<div class="yii2-media-item">
    <div class="image">
        <img src="<?php $model->getThumbnail()?>" />
    </div>
    <div class="info">
        <h5><?= $model->name?></h5>
        <small><?php echo $model->getTypeName()?></small>
        <small><?php echo $model->getReadableSize()?></small>
    </div>
</div>
