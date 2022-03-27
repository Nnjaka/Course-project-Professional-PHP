<?php

namespace App\Exceptions;

class UserNotFoundException extends \Exception
{
    protected $message = 'Пользователь не найден';
}
