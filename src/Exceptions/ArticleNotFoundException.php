<?php

namespace App\Exceptions;

class ArticleNotFoundException extends \Exception
{
    protected $message = 'Статья не найдена';
}
