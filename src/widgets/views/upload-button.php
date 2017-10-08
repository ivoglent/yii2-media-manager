<?php
/**
 * @var \ivoglent\media\manager\widgets\UploadButton $context
 */

$buttonId = substr(md5(microtime()), 0, 6);
if (!isset($value) || empty($value)) {
    if (isset($model)) {
        $value = $model->$attribute;
    }
}
?>
<?php \yii\widgets\Pjax::begin([
    'id' => 'yii2-media-upload-button',
    'enablePushState' => false,
    'timeout' => 10000
])?>
<?php if ($createElement) :?>
    <?php if(isset($model)) :?>
        <?=\yii\helpers\Html::activeHiddenInput($model, $attribute, [
            'id' => "input-$buttonId"
        ])?>
    <?php else :?>
        <?=\yii\helpers\Html::hiddenInput($target, $value, [
            'id' => "input-$buttonId"
        ])?>
    <?php endif;?>
<?php endif;?>
<?php if (empty($value)) :?>
    <button id="<?="button-$buttonId"?>" class="btn btn-primary" type="button" data-media-dialog data-show-image="<?="#button-$buttonId"?>" data-target="<?="#input-{$buttonId}"?>">
        <i class="fa fa-plus"></i>
    </button>
<?php else :?>
    <button id="<?="button-$buttonId"?>" class="selected" type="button" data-media-dialog data-show-image="<?="#button-$buttonId"?>" data-target="<?="#input-{$buttonId}"?>">
        <img src="<?=str_replace('primary_', 'thumb_', $value)?>" />
        <div class="media-selected-hover"><i class="fa fa-pencil"></i> Change</div>
    </button>
<?php endif;?>
<?php \yii\widgets\Pjax::end()?>
