<?php
/**
 * @project  Investment Deals
 * @copyright © 2017 by ivoglent
 * @author ivoglent
 * @time  9/7/17.
 */


namespace ivoglent\media\manager;

use yii\base\InvalidConfigException;
use yii\helpers\BaseUrl;

class Module extends \yii\base\Module
{
    public $controllerNamespace         = 'ivoglent\media\manager\controllers';
    public $userClass                   = 'common\models\User';

    public $uploadDir                   = '';
    public $uploadUrl                   = '';

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $this->checkUploadDir();
        $this->userClass = \Yii::$app->user->identityClass;
    }

    /**
     * @throws InvalidConfigException
     */
    private function checkUploadDir()
    {
        if (empty($this->uploadDir)) {
            throw new InvalidConfigException("Missing uploadDir config for media manager");
        }
        if (!is_dir($this->uploadDir) || !is_writable($this->uploadDir)) {
            throw new InvalidConfigException('Upload directory does not exists or non-writeable : ' . $this->uploadDir);
        }
        if (empty($this->uploadUrl)) {
            $rootPath = \Yii::getAlias('@webroot');
            $this->uploadUrl = '/' . str_replace($rootPath, '', $this->uploadDir);
        }
    }
}