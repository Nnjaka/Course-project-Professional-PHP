<?php

namespace App\Classes\User;


interface IUser
{
    public function getId(): ?int;
    public function getFirstName(): string;
    public function getLastName(): string;
    public function getEmail(): string;
}