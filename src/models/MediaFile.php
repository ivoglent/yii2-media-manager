<?php
/**
 * @project  Investment Deals
 * @copyright © 2017 by ivoglent
 * @author ivoglent
 * @time  9/8/17.
 */


namespace ivoglent\media\manager\models;


use ivoglent\media\manager\components\Size;
use ivoglent\media\manager\components\UploadOptions;
use ivoglent\media\manager\components\UploadResult;
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
        'jpg', 'png', 'bmp', 'gif', //Photo file
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
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, png, bmp', 'maxSize' => 1024 * 1024 * 5, 'tooBig' => 'Limit is 5MB'],
        ];
    }

    /**
     * @return UploadResult
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
     * Upload and process the photo file
     * @return UploadResult
     */
    public function uploadPhoto()
    {
        $result = [];
        if ($this->validate()) {
            $filename = $this->options->getFilename($this->file->name);
            $filePath = Media::getCurrentDirectory() . DIRECTORY_SEPARATOR . $filename;
            $result['originName'] = $this->file->name;
            if ($this->file->saveAs($filePath)) {
                $result['originPath'] = $filePath;
                if ($this->options->resize) {
                    $tsize = new Size($this->options->resizeTo);
                    $size    = new \Imagine\Image\Box($tsize->width, $tsize->height);
                    $imagine = new \Imagine\Gd\Imagine();
                    $resizedName = 'primary_' . $filename;
                    $resizedPath = Media::getCurrentDirectory() . DIRECTORY_SEPARATOR . $resizedName;
                    $imagine->open($filePath)->resize($size)->save($resizedPath);
                    $filename = $resizedName;
                    $filePath = $resizedPath;
                }
                $result['success'] =  true;
                $result['fileName'] = $filename;
                $result['filePath'] = $filePath;
                $result['size'] = $this->file->size;
                if ($this->options->generateThumbnail) {
                    $thumbName = 'thumb_' . $filename;
                    $thumbPath = Media::getCurrentDirectory() . DIRECTORY_SEPARATOR . $thumbName;
                    $tsize = new Size($this->options->thumbnailSize);
                    $size    = new \Imagine\Image\Box($tsize->width, $tsize->height);
                    $imagine = new \Imagine\Gd\Imagine();
                    try {
                        $imagine->open($filePath)->thumbnail($size)->save($thumbPath);
                        $result['thumbnailPath'] = $thumbPath;
                        $result['thumbnailName'] = $thumbName;

                    } catch (\Exception $e) {
                        //Nothing to do
                        \Yii::$app->log->logger->log($e);
                    }
                }
            }

        }
        return new UploadResult($result);
    }
}