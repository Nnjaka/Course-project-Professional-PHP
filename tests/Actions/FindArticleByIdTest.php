<?php

namespace Tests\Action;

use App\Classes\Article\Article;
use App\Exceptions\ArticleNotFoundException;
use App\Http\Actions\FindArticleById;
use App\Http\ErrorResponse;
use App\Http\Request;
use App\Repositories\ArticleRepositoryInterface;
use PDOStatement;
use PHPUnit\Framework\TestCase;

class FindArticleByIdTest extends TestCase
{
    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testItReturnsErrorResponseIfNoIdProvided(): void
    {
        $request = new Request([], [], '');
        $articleRepository = $this->getArticleRepository([]);

        $action = new FindArticleById($articleRepository);
        $response = $action->handle($request);

        $this->assertInstanceOf(ErrorResponse::class, $response);

        $this->expectOutputString(
            '{"success":false,"reason":"No such query param in the request: id"}'
        );

        $response->send();
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testItReturnsErrorResponseIfArticleNotFound(): void
    {
        $request = new Request(['id' => '333'], [], '');

        $articleRepository = $this->getArticleRepository([]);
        $action = new FindArticleById($articleRepository);

        $response = $action->handle($request);
        $this->assertInstanceOf(ErrorResponse::class, $response);

        $this->expectOutputString('{"success":false,"reason":"Not found"}');
        $response->send();
    }

    private function getArticleRepository(array $articles): ArticleRepositoryInterface
    {
        $statementStub = $this->createStub(PDOStatement::class);

        return new class($articles) implements ArticleRepositoryInterface
        {

            public function __construct(
                private array $articles
            ) {
            }

            public function save(Article $article): void
            {
            }

            public function get(int $id): Article
            {
                throw new ArticleNotFoundException("Not found");
            }

            public function getArticle($statementStub, $id): Article
            {
                throw new ArticleNotFoundException("Not found");
            }
        };
    }
}
