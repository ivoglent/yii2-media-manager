<?php
/**
 * @project  Investment Deals
 * @copyright © 2017 by ivoglent
 * @author ivoglent
 * @time  9/8/17.
 */


namespace ivoglent\media\manager\models;


use yii\base\Model;
use yii\web\UploadedFile;

class MediaFile extends Model
{

    const MEDIA_TYPE_PHOTO          = 0;
    const MEDIA_TYPE_VIDEO          = 1;
    const MEDIA_TYPE_DOCUMENT       = 2;
    /**
     * Uploadable file
     * @var UploadedFile
     */
    public $file;

    /**
     * @var UploadOptions
     */
    public $options;


    protected $allowedExtensions = [
        'media' => ['jpg', 'png', 'bmp', 'gif', ''], //Photo file
        'doc' , 'docx', 'xls', 'xlsx', 'ppt', 'pptx', // Document files
        'zip', 'tar', '7gz', 'rar', // Compressed files
    ];

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => implode(', ', $this->allowedExtensions)],
        ];
    }

    /**
     * @return bool|string
     */
    public function upload()
    {
        if (empty($this->options)) {
            $this->options = new UploadOptions([
                'filename' => $this->file->name,
            ]);
        }
        switch ($this->options->type) {
            case self::MEDIA_TYPE_PHOTO :
                return $this->uploadPhoto();
                break;
        }
    }

    /**
     * @return bool|string
     */
    public function uploadPhoto()
    {
        if ($this->validate()) {
            $this->image->saveAs(Media::getCurrentDirectory() . DIRECTORY_SEPARATOR . $this->image->baseName . '.' . $this->image->extension);
            return $this->options->filename;
        } else {
            return false;
        }
    }
}