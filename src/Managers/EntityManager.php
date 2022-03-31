<?php

namespace App\Managers;

use App\Classes\EntityInterface;
use App\Managers\EntityManagerInterface;
use App\Classes\Article\Article;
use App\Classes\User\User;
use App\Classes\Comment\Comment;
use App\Commands\CreateEntityCommand;
use App\Commands\DeleteEntityCommand;
use App\Commands\CreateUserCommandHandler;
use App\Commands\CreateArticleCommandHandler;
use App\Commands\CreateCommentCommandHandler;
use App\Commands\DeleteUserCommandHandler;
use App\Commands\DeleteArticleCommandHandler;
use App\Commands\DeleteCommentCommandHandler;

class EntityManager implements EntityManagerInterface
{
    public function createCommandHandler(EntityInterface $entity)
    {
        $commandHandler = match ($entity::class) {
            User::class => new CreateUserCommandHandler(),
            Article::class => new CreateArticleCommandHandler(),
            Comment::class => new CreateCommentCommandHandler()
        };
        return $commandHandler->handle(new CreateEntityCommand($entity), $entity);
    }

    public function deleteCommandHandler(string $class, int $id)
    {
        $commandHandler = match ($class) {
            'user' => new DeleteUserCommandHandler(),
            'article' => new DeleteArticleCommandHandler(),
            'comment' => new DeleteCommentCommandHandler()
        };
        return $commandHandler->handle(new DeleteEntityCommand($id), $id);
    }
};
