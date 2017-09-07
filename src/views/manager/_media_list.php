<?php
/**
 * @project  Investment Deals
 * @copyright © 2017 by ivoglent
 * @author ivoglent
 * @time  9/7/17.
 */
?>
<?php \yii\widgets\Pjax::begin([
    'id' => 'yii2-media-items',
    'enablePushState' => false,
    'timeout' => 10000
]);?>
<div class="yii2-media-list">
    <?= \yii\widgets\ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '__media_item'
    ])?>

</div>
<?php \yii\widgets\Pjax::end()?>
