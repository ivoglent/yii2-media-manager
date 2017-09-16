<?php

namespace ivoglent\media\manager\models;

use Yii;

/**
 * This is the model class for table "media".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property int $type
 * @property string $name
 * @property string $folder
 * @property double $size
 * @property string $thumb
 * @property integer $privacy
 * @property string $meta_data
 * @property integer $created_by
 * @property string $created_at
 */
class Media extends \yii\db\ActiveRecord
{
    const MEDIA_PRIVACY_PUBLIC          = 1;
    const MEDIA_PRIVACY_PRIVATE         = 0;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'media';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'name', 'size', 'created_by'], 'required'],
            [['size'], 'number'],
            [['privacy', 'type', 'created_by'], 'integer'],
            [['created_at'], 'safe'],
            [['title', 'thumb'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 500],
            [['folder'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'type' => Yii::t('app', 'Type'),
            'name' => Yii::t('app', 'Name'),
            'folder' => Yii::t('app', 'Folder'),
            'size' => Yii::t('app', 'Size'),
            'thumb' => Yii::t('app', 'Thumb'),
            'privacy' => Yii::t('app', 'Privacy'),
            'meta_data' => Yii::t('app', 'Privacy'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @return string
     */
    public static function getCurrentDirectory()
    {
        $uploadDir = Yii::$app->controller->module->uploadDir;
        $currentDir = self::currentDir();
        $dir = $uploadDir .'/' . $currentDir;
        if (!is_dir($dir)) {
            mkdir($dir, 0777);
        }
        return $dir;
    }

    /**
     * @return string
     */
    public static function currentDir()
    {
        $currentTime = date('Ym', time());
        $currentDir = dechex(intval($currentTime) * 10000);
        return $currentDir;
    }
    /**
     * @return string
     */
    public static function getCurrentDirectoryUrl()
    {
        $uploadUrl = Yii::$app->controller->module->uploadUrl;
        $currentDir = self::currentDir();
        return $uploadUrl . '/' . $currentDir;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        $uploadDir = Yii::$app->controller->module->uploadDir;
        $uploadPath = $uploadDir . DIRECTORY_SEPARATOR . $this->folder . DIRECTORY_SEPARATOR . $this->name;
        return $uploadPath;
    }

    /**
     * @param string $file
     * @return string
     */
    public function getUrl($file = '')
    {
        if (empty($file)) {
            $file = $this->name;
        }
        $uploadUrl = Yii::$app->controller->module->uploadUrl;
        return $uploadUrl . '/' . $this->folder . '/' . $file;
    }


    /**
     * @return string
     */
    public function getThumbnail()
    {
        return $this->getUrl($this->thumb);
    }

    public function getTypeName()
    {

    }

    public function getReadableSize()
    {

    }
}
