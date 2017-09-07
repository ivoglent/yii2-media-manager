<?php
/**
 * @project  Investment Deals
 * @copyright © 2017 by ivoglent
 * @author ivoglent
 * @time  9/7/17.
 */
?>

<?= \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '__media_item'
])?>
