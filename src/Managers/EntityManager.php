<?php

namespace App\Managers;

use App\Classes\EntityInterface;
use App\Managers\EntityManagerInterface;
use App\Commands\SaveCommand;
use App\Commands\DeleteCommand;
use App\Repositories\ArticleRepository;
use App\Repositories\CommentRepository;
use App\Repositories\EntityRepository;
use App\Repositories\UserRepository;


class EntityManager implements EntityManagerInterface
{
    protected function getRepositoryName(string $class): EntityRepository
    {

        return match (mb_strtoupper($class)) {
            "USER" => new UserRepository(),
            "ARTICLE" => new ArticleRepository(),
            "COMMENT" => new CommentRepository()
        };
    }

    protected function getClassName(EntityInterface $entity): string
    {
        $arrayClass = (explode('\\', $entity::class));
        return end($arrayClass);
    }

    public function save(EntityInterface $entity)
    {
        $command = new SaveCommand($this->getRepositoryName($this->getClassName($entity)));
        return $command->handle($entity);
    }

    public function delete(string $class, int $id)
    {
        $command = new DeleteCommand($this->getRepositoryName($class));
        return $command->handle($id);
    }
}
