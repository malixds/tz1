<?php

namespace App\Exceptions;

use Exception;

class LinkIsExpired extends Exception
{
    public function __construct($message = "Ссылка истекла", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
