<?php

namespace App\Repositories;

use App\Classes\EntityInterface;

interface EntityRepositoryInterface
{
    public function get(int $id): EntityInterface;
}
