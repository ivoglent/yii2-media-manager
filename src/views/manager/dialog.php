<?php
/**
 * @project  Investment Deals
 * @copyright © 2017 by ivoglent
 * @author ivoglent
 * @time  9/7/17.
 *
 * @var \yii\web\View $this
 */
?>
<div id="media-manager-dialog" data-backdrop="static" class="modal fade bs-media-modal-lg" tabindex="-1" role="dialog" aria-labelledby="Media Manager">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?=Yii::t('app', 'Media manager')?></h4>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#media-manager-list" aria-controls="media-manager-list" role="tab" data-toggle="tab">Media list</a></li>
                    <li role="presentation"><a href="#media-manager-upload" aria-controls="media-manager-upload" role="tab" data-toggle="tab">Upload new</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="media-manager-list">
                        <div class="media-container">
                            <?= $this->render('_media_list', ['dataProvider' => $dataProvider])?>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="media-manager-upload">
                        <div class="media-container">
                            <?= $this->render('_form', ['model' => $model])?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="yii-media-delete">Delete (0)</button>
                <button type="button" id="media-manager-apply" class="btn btn-primary">Apply (0)</button>
            </div>
        </div>
    </div>
</div>