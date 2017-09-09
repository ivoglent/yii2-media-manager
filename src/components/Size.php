<?php
/**
 * @project  Investment Deals
 * @copyright © 2017 by ivoglent
 * @author ivoglent
 * @time  9/8/17.
 */


namespace ivoglent\media\manager\components;


use yii\base\InvalidConfigException;
use yii\base\Object;

class Size extends Object
{
    /**
     * @var float
     */
    public $width;

    /**
     * @var float
     */
    public $height;

    /**
     * Size constructor.
     * @param array $size
     */
    public function __construct($size)
    {
        if (is_array($size)) {
            $size = array_values($size);
            $config = [
                'width' => $size[0],
                'height' => $size[1],
            ];
        } else {
            $size = explode('x', $size);
            if (count($size) == 2 && is_numeric($size[0]) && is_numeric($size[1])) {
                $config = [
                    'width'     => $size[0],
                    'height'    => $size[1]
                ];
            } else {
                throw new InvalidConfigException('Invalid size. Allowed array [width, height] or string WIDTHxHEIGHT');
            }
        }
        parent::__construct($config);
    }

    /**
     * @param $width
     * @param null $height
     * @return Size
     */
    public function resize($width, $height = null)
    {
        if (is_null($height)) {
            $height = ($this->height * $width ) / $this->width;
        }
        return new self([$width, $height]);
    }
}