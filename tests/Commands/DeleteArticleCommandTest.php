<?php

namespace Test\Commands;

use App\Classes\Article\Article;
use App\Commands\DeleteArticleCommandHandler;
use App\Commands\DeleteEntityCommand;
use App\Connections\ConnectorInterface;
use App\Repositories\ArticleRepository;
use App\Connections\SqlLiteConnectorInterface;
use PDOStatement;
use App\config\SqlLiteConfig;
use PHPUnit\Framework\TestCase;

class DeleteArticleCommandTest extends TestCase
{
    public function testItDeleteArticleFromDatabase(): void
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

        $repository = new ArticleRepository($connectionStub);

        $createArticleCommandHandler = new DeleteArticleCommandHandler($repository, $connectionStub);

        $command = new DeleteEntityCommand(3);

        $createArticleCommandHandler->handle($command);
    }
}
