<?php

namespace Test\Commands;

use App\Classes\Article\Article;
use App\Commands\CreateArticleCommandHandler;
use App\Commands\CreateEntityCommand;
use App\Connections\ConnectorInterface;
use App\Repositories\ArticleRepositoryInterface;
use App\Exceptions\ArticleIdExistException;
use PHPUnit\Framework\TestCase;

class CreateArticleCommandTest extends TestCase
{
    public function testItThrowsAnExceptionWhenArticleAlreadyExists()
    {
        $connectionStub = $this->createStub(ConnectorInterface::class);
        $articleRepositoryStub = $this->createStub(ArticleRepositoryInterface::class);
        $createArticleCommandHandler = new CreateArticleCommandHandler($articleRepositoryStub, $connectionStub);

        $this->expectException(ArticleIdExistException::class);
        $this->expectExceptionMessage('Статья с таким id уже существует в системе');

        $command = new CreateEntityCommand(
            new Article(
                3,
                'New header',
                'Any text'
            )
        );

        $createArticleCommandHandler->handle($command);
    }
}
