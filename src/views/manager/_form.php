<?php
/**
 * @project  Investment Deals
 * @copyright © 2017 by ivoglent
 * @author ivoglent
 * @time  9/8/17.
 * @var \ivoglent\media\manager\models\Media $model
 */
?>

<div class="yii2-media-upload-form">
    <?php $form = \yii\widgets\ActiveForm::begin(
        [
            'method' => 'post',
            'options' => [
                'encrypt' => 'multipart/form-data'
            ]
        ]
    )?>
    <h5>Please select file(s)</h5>
    <div class="col-sm-12">
        <div class="col-sm-6">
            <?=$form->field($model, 'name')->fileInput([
                'style' => 'display:none',
                'class' => 'media-file'
            ])->label('Browse&hellip;', [
                'class' => 'btn btn-primary'
            ])?>
            <div class="yii2-media-upload-progress" id="yii2-media-upload-progress">
                <span class="info">10% Complete</span>
                <div class="progress-bar" role="progressbar" aria-valuenow="70"
                     aria-valuemin="0" aria-valuemax="100" style="width:80%">

                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="yii2-media-upload-preview" id="yii2-media-upload-preview">

            </div>

        </div>
    </div>

    <?php \yii\widgets\ActiveForm::end()?>

</div>
<script>
    ;(function($){
        $(document).on('change', '.media-file', function() {
            var input = $(this),
                numFiles = input.get(0).files ? input.get(0).files.length : 1,
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', input);
        });
        $(document).ready( function() {
            $(':file').on('fileselect', function(event, input) {
                var fr = new FileReader();
                var preview = $('<img>');
                $('#yii2-media-upload-progress').hide();
                fr.onload = function(){
                    $(preview).attr('src', fr.result);
                    $('#yii2-media-upload-preview').html(preview);
                    $('#yii2-media-upload-progress').show();
                    $('.media-file').prop('disabled', true);
                    upload($(input)[0]);
                }
                fr.readAsDataURL(input.files[0]);
            });
        });

        function upload(input) {
            yii.media.upload(input, function(result){
                console.log(result);
            }, function(percent){
                $('.yii2-media-upload-progress .progress-bar').css({width : percent + '%'});
                $('.yii2-media-upload-progress .info').html(percent + '% completed.');
            })
        }

    })(jQuery);

</script>