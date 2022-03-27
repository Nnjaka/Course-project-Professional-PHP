<?php

namespace Test\Commands;

use App\Classes\Comment\Comment;
use App\Commands\DeleteCommentCommandHandler;
use App\Commands\DeleteEntityCommand;
use App\Connections\ConnectorInterface;
use App\Repositories\CommentRepository;
use App\Connections\SqlLiteConnectorInterface;
use PDOStatement;
use App\config\SqlLiteConfig;
use PHPUnit\Framework\TestCase;

class DeleteCommentCommandTest extends TestCase
{
    public function testItDeleteCommentFromDatabase(): void
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

        $createCommentCommandHandler = new DeleteCommentCommandHandler($repository, $connectionStub);

        $command = new DeleteEntityCommand(3);

        $createCommentCommandHandler->handle($command);
    }
}
