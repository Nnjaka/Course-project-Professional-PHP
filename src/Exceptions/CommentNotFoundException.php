<?php

namespace App\Exceptions;

class CommentNotFoundException extends \Exception
{
    protected $message = 'Комментарий не найден';
}
