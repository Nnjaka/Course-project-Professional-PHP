<?php

namespace App\Repositories;

use PDOStatement;
use App\Classes\User\IUser;

interface UserRepositoryInterface
{
    public function get(int $id): IUser;
    public function getUser(PDOStatement $statement): IUser;
    public function getUserByEmail(string $email): IUser;
}
