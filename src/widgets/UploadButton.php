<?php
namespace ivoglent\media\manager\widgets;


use ivoglent\media\manager\Widget;

class UploadButton extends Widget
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $this->registerAssets([
            'script' => [
                'scripts/yii2media.js'
            ],
            'styles' => [
                'styles/yii2media.css'
            ]
        ]);
    }

    public function run()
    {

        return $this->render('upload-button', []);
    }
}