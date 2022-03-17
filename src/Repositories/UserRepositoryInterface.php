<?php

namespace App\Repositories;

use App\Classes\User\User;

interface UserRepositoryInterface
{
    public function get(int $id): User;
}
