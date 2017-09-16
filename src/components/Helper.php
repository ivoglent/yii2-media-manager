<?php
/**
 * @project  Investment Deals
 * @copyright © 2017 by ivoglent
 * @author ivoglent
 * @time  9/11/17.
 */


namespace ivoglent\media\manager\components;


class Helper
{
    /**
     * @param $name
     * @param $len
     * @return string
     */
    public static function validateFilename($name, $len)
    {
        if (strlen($name) > $len) {
            $fps = explode('.', $name);
            $ext = end($fps);
            $name = substr($name, 0, $len - 4) . '.' . $ext;
        }
        return $name;
    }
}