<?php

namespace ivoglent\media\manager\models;

use ivoglent\media\manager\components\Size;
use Yii;
use yii\helpers\BaseUrl;

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
    public static function getCurrentDirectory($folder = false)
    {
        $uploadDir = Yii::$app->controller->module->uploadDir;
        $currentDir = $folder ? $folder : self::currentDir();
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
    public function getPath($name = '')
    {
        if (empty($name)) {
            $name = $this->name;
        }
        $uploadDir = Yii::$app->controller->module->uploadDir;
        $uploadPath = $uploadDir . DIRECTORY_SEPARATOR . $this->folder . DIRECTORY_SEPARATOR . $name;
        return $uploadPath;
    }

    /**
     * @param string $file
     * @return string
     */
    public function getUrl($file = '', $scheme = false)
    {
        if (empty($file)) {
            $file = $this->name;
        }
        $uploadUrl = Yii::$app->controller->module->uploadUrl;
        if (!$scheme) {
            $uploadUrl = str_replace(BaseUrl::base(true), '', $uploadUrl);
        }
        return $uploadUrl . '/' . $this->folder . '/' . $file;
    }


    /**
     * @return string
     */
    public function getThumbnail($size = null)
    {
        $file = $this->thumb;
        if (!empty($size)) {
            /** @var Size $size */
            $size = new Size($size);
            $file = $this->generateThumbnail($size);
        }
        return $this->getUrl($file);
    }

    /**
     * @param Size $tsize
     * @return mixed|null
     */
    public function generateThumbnail(Size $tsize) {
        $thumbName = str_replace('thumb_', 'thumb_' . $tsize->width . 'x' . $tsize->height, $this->thumb );
        $thumbPath = Media::getCurrentDirectory($this->folder) . DIRECTORY_SEPARATOR . $thumbName;
        if (!file_exists($thumbPath)) {
            $size    = new \Imagine\Image\Box($tsize->width, $tsize->height);
            $imagine = new \Imagine\Gd\Imagine();
            try {
                $imagine->open($filePath)->thumbnail($size)->save($thumbPath);
            } catch (\Exception $e) {
                //Nothing to do
                \Yii::$app->log->logger->log($e);
                return null;
            }
        }
        return $thumbName;

    }

    public function getTypeName()
    {

    }

    public function getReadableSize()
    {

    }


    /**
     * Delete related files (origin file and thumbnail)
     * after model was deleted
     */
    public function afterDelete()
    {
        parent::afterDelete(); // TODO: Change the autogenerated stub
        $file = $this->getPath();
        $thumb = $this->getPath($this->thumb);
        @unlink($file);
        @unlink($thumb);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }
}
