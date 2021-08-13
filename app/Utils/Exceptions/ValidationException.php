<?php
namespace App\Utils\Exceptions;


class ValidationException extends \Exception
{
    protected $errors;

    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public static function withErrors($errors)
    {
        $e = new self();
        $e->setErrors($errors);
        return $e;
    }

}
