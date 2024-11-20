<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    protected $message;
    protected $code;
    protected $error;

    public function __construct($message = "Something went wrong", $code = 500, $error = true)
    {
        parent::__construct($message, $code);
        $this->error = $error;
    }

    public function getError()
    {
        return $this->error;
    }
}