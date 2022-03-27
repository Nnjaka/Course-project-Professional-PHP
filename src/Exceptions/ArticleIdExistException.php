<?php

namespace App\Exceptions;

class ArticleIdExistException extends \Exception
{
    protected $message = 'Статья с таким id уже существует в системе';
}
