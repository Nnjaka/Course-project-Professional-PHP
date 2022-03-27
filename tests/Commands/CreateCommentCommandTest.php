<?php

namespace Test\Commands;

use App\Classes\Comment\Comment;
use App\Commands\CreateCommentCommandHandler;
use App\Commands\CreateEntityCommand;
use App\Connections\ConnectorInterface;
use App\Repositories\CommentRepositoryInterface;
use App\Exceptions\CommentIdExistException;
use PHPUnit\Framework\TestCase;

class CreateCommentCommandTest extends TestCase
{
    public function testItThrowsAnExceptionWhenCommentAlreadyExists()
    {
        $connectionStub = $this->createStub(ConnectorInterface::class);
        $CommentRepositoryStub = $this->createStub(CommentRepositoryInterface::class);
        $createCommentCommandHandler = new CreateCommentCommandHandler($CommentRepositoryStub, $connectionStub);

        $this->expectException(CommentIdExistException::class);
        $this->expectExceptionMessage('Комментарий с таким id уже существует в системе');

        $command = new CreateEntityCommand(
            new Comment(
                5,
                2,
                'Some comment'
            )
        );

        $createCommentCommandHandler->handle($command);
    }
}
