<?php

namespace Test\Repositories;

use App\Connections\SqlLiteConnectorInterface;
use App\Repositories\CommentRepository;
use App\Exceptions\CommentNotFoundException;
use App\Commands\CreateEntityCommand;
use App\Commands\CreateCommentCommandHandler;
use App\Classes\Comment\Comment;
use PDOStatement;
use App\config\SqlLiteConfig;
use PHPUnit\Framework\TestCase;

class CommentRepositoryTest extends TestCase
{
    public function testItThrowsAnExceptionWhenCommentNotFound()
    {
        $connectionStub = $this->createStub(SqlLiteConnectorInterface::class);

        $statementStub = $this->createStub(PDOStatement::class);
        $statementStub->method('fetch')->willReturn(false);

        $repository = new CommentRepository($connectionStub);

        $this->expectException(CommentNotFoundException::class);
        $this->expectExceptionMessage('Комментарий не найден');

        $repository->getComment($statementStub, 3);
    }

    public function testItSavesCommentToDatabase(): void
    {
        $connectionStub = $this->createStub(SqlLiteConnectorInterface::class);
        $statementMock = $this->createMock(PDOStatement::class);

        $statementMock
            ->method('execute')
            ->with([
                ':id' => 3,
            ]);

        $connectionStub->method('getConnection')->willReturn(new \PDO(SqlLiteConfig::DSN));
        $this->assertInstanceOf(SqlLiteConnectorInterface::class, $connectionStub);

        $repository = new CommentRepository($connectionStub);

        $createCommentCommandHandler = new CreateCommentCommandHandler($repository, $connectionStub);

        $command = new CreateEntityCommand(
            new Comment(
                3,
                2,
                'Some coment'
            )
        );
        $createCommentCommandHandler->handle($command);
    }
}
