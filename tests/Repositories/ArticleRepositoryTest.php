<?php

namespace Test\Repositories;

use App\Connections\SqlLiteConnectorInterface;
use App\Repositories\ArticleRepository;
use App\Exceptions\ArticleNotFoundException;
use App\Commands\CreateEntityCommand;
use App\Commands\CreateArticleCommandHandler;
use App\Classes\Article\Article;
use PDOStatement;
use App\config\SqlLiteConfig;
use PHPUnit\Framework\TestCase;

class ArticleRepositoryTest extends TestCase
{
    public function testItThrowsAnExceptionWhenArticleNotFound()
    {
        $connectionStub = $this->createStub(SqlLiteConnectorInterface::class);

        $statementStub = $this->createStub(PDOStatement::class);
        $statementStub->method('fetch')->willReturn(false);

        $repository = new ArticleRepository($connectionStub);

        $this->expectException(ArticleNotFoundException::class);
        $this->expectExceptionMessage('Статья не найдена');

        $repository->getArticle($statementStub, 3);
    }

    public function testItSavesArticleToDatabase(): void
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

        $createArticleCommandHandler = new CreateArticleCommandHandler($repository, $connectionStub);

        $command = new CreateEntityCommand(
            new Article(
                3,
                'Some header',
                'Some text'
            )
        );
        $createArticleCommandHandler->handle($command);
    }
}
