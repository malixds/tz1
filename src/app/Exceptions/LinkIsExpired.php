<?php

namespace App\Exceptions;

use Exception;

class LinkIsExpired extends Exception
{
    protected $message = "Ссылка истекла";
}
