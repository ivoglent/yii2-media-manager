<?php
/**
 * @var \ivoglent\media\manager\widgets\UploadButton $context
 */

$buttonId = substr(md5(microtime()), 0, 6);

?>
<?php \yii\widgets\Pjax::begin([
    'id' => 'yii2-media-upload-button',
    'enablePushState' => false,
    'timeout' => 10000
])?>
<?php if(isset($model)) :?>
    <?=\yii\helpers\Html::activeHiddenInput($model, $attribute, [
        'id' => "input-$buttonId"
    ])?>
<?php else :?>
    <?=\yii\helpers\Html::hiddenInput($target, null, [
        'id' => "input-$buttonId"
    ])?>
<?php endif;?>
<button id="<?="button-$buttonId"?>" type="button" data-media-dialog data-show-image="<?="#button-$buttonId"?>" data-target="<?="#input-{$buttonId}"?>">Upload</button>
<?php \yii\widgets\Pjax::end()?>
