<?php

namespace App\Commands;

use App\Repositories\EntityRepositoryInterface;

class DeleteCommand
{
    protected EntityRepositoryInterface $entityRepository;

    public function __construct(EntityRepositoryInterface $entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }

    public function handle(int $id): void
    {
        $this->entityRepository->delete($id);
    }
}
