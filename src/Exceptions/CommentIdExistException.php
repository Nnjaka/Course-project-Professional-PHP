<?php

namespace App\Exceptions;

class CommentIdExistException extends \Exception
{
    protected $message = 'Комментарий с таким id уже существует в системе';
}
