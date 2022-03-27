<?php

namespace App\Classes\User;

use App\Classes\EntityInterface;

interface IUser extends EntityInterface
{
    public function getId(): ?int;
    public function getFirstName(): string;
    public function getLastName(): string;
    public function getEmail(): string;
}
