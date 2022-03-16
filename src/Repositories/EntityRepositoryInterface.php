<?php

namespace App\Repositories;

use App\Classes\EntityInterface;

interface EntityRepositoryInterface
{
    public function save(EntityInterface $entity): void;
    public function get(int $id): EntityInterface;
    public function delete(int $id): void;
}
