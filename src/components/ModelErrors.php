<?php
/**
 * @project  Investment Deals
 * @copyright © 2017 by ivoglent
 * @author ivoglent
 * @time  9/10/17.
 */


namespace ivoglent\media\manager\components;


class ModelErrors
{
    public $errors = [];

    /**
     * ModelErrors constructor.
     * @param $_errors
     */
    public function __construct($_errors)
    {
        foreach ($_errors as $name => $errorList) {
            foreach ($errorList as $error) {
                $this->errors[$name][] = $error;
            }
        }
    }

    public function __toString()
    {
        $errorMessage = '';
        foreach ($this->errors as $name => $error) {
            $errorMessage .= "<strong> {$name} </strong>: " . implode('<br />', $error);
        }
        return $errorMessage;
    }
}