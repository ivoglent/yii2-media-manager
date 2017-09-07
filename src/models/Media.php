<?php

namespace ivoglent\media\manager\models;

use Yii;

/**
 * This is the model class for table "media".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $type
 * @property string $name
 * @property double $size
 * @property string $thumb
 * @property integer $privacy
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
            [['privacy', 'created_by'], 'integer'],
            [['created_at'], 'safe'],
            [['title', 'thumb'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 500],
            [['type'], 'string', 'max' => 5],
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
            'size' => Yii::t('app', 'Size'),
            'thumb' => Yii::t('app', 'Thumb'),
            'privacy' => Yii::t('app', 'Privacy'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    protected function getUserDirectory()
    {
        $userId = $this->created_by;
        if ($this->privacy == self::MEDIA_PRIVACY_PUBLIC) {
            $userId = 0;
        }
    }

    public function getThumbnail()
    {

    }

    public function getTypeName()
    {

    }

    public function getReadableSize()
    {

    }
}
