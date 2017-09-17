<?php
/**
 * @project  Investment Deals
 * @copyright © 2017 by ivoglent
 * @author ivoglent
 * @time  9/9/17.
 */


namespace ivoglent\media\manager\components;


use yii\base\Object;

class UploadResult extends Object
{
    /**
     * @var bool
     */
    public $success                 = false;
    /**
     * @var string
     */
    public $originName              = '';
    /**
     * @var string
     */
    public $originPath              = '';
    /**
     * @var string
     */
    public $fileName                = '';
    /**
     * @var string
     */
    public $filePath                = '';
    /**
     * @var string
     */
    public $thumbnailName           = '';
    /**
     * @var string
     */
    public $thumbnailPath           = '';
    /**
     * @var string
     */
    public $size                    = '';

    /**
     * @var string
     */
    public $error                   = '';

    /**
     * Media ID
     * @var int
     */
    public $id                      = 0;

}