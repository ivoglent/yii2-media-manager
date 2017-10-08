<?php
namespace ivoglent\media\manager\widgets;


use ivoglent\media\manager\Widget;
use yii\base\InvalidConfigException;
use yii\base\Model;

class UploadButton extends Widget
{
    /**
     * Model of this attribute
     * @var Model $model
     */
    public $model;
    /**
     * Name of attribute
     * @var string $attribute
     */
    public $attribute;

    /** @var string  */
    public $value = '';

    public $createElement = true;

    /**
     * Name of hidden input if you want to use this widget
     * without a model
     * @var string $target
     */
    public $target;

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

    /**
     * @return string
     * @throws InvalidConfigException
     */
    public function run()
    {
        $data = [];
        if (!empty($this->model) && !empty($this->attribute)) {
            $data['model'] = $this->model;
            $data['attribute'] = $this->attribute;
        } elseif (!empty($this->target)) {
            $data['target'] = $this->target;
            $data['value'] = $this->value;
        }
        $data['createElement'] = $this->createElement;
        return $this->render('upload-button', $data);
    }
}