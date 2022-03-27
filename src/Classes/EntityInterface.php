<?php

namespace App\Classes;

interface EntityInterface
{
    public function getId(): ?int;
    public function __toString(): string;
}
