<?php

namespace App\Commands;

use App\Classes\EntityInterface;
use App\Repositories\EntityRepositoryInterface;

class SaveCommand
{
    private EntityRepositoryInterface $entityRepository;

    public function __construct(EntityRepositoryInterface $entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }

    public function handle(EntityInterface $entity): void
    {
        $this->entityRepository->save($entity);
    }
}
