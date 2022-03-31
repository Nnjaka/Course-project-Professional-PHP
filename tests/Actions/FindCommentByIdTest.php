<?php

namespace Tests\Action;

use App\Classes\Comment\Comment;
use App\Exceptions\CommentNotFoundException;
use App\Http\Actions\FindCommentById;
use App\Http\ErrorResponse;
use App\Http\Request;
use App\Http\SuccessfulResponse;
use App\Repositories\CommentRepositoryInterface;
use PDOStatement;
use PHPUnit\Framework\TestCase;

class FindCommentByIdTest extends TestCase
{
    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testItReturnsErrorResponseIfNoIdProvided(): void
    {
        $request = new Request([], [], '');
        $CommentRepository = $this->getCommentRepository([]);

        $action = new FindCommentById($CommentRepository);
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
    public function testItReturnsErrorResponseIfCommentNotFound(): void
    {
        $request = new Request(['id' => '333'], [], '');

        $CommentRepository = $this->getCommentRepository([]);
        $action = new FindCommentById($CommentRepository);

        $response = $action->handle($request);
        $this->assertInstanceOf(ErrorResponse::class, $response);

        $this->expectOutputString('{"success":false,"reason":"Not found"}');
        $response->send();
    }

    private function getCommentRepository(array $Comments): CommentRepositoryInterface
    {
        $statementStub = $this->createStub(PDOStatement::class);

        return new class($Comments) implements CommentRepositoryInterface
        {

            public function __construct(
                private array $Comments
            ) {
            }

            public function save(Comment $Comment): void
            {
            }

            public function get(int $id): Comment
            {
                throw new CommentNotFoundException("Not found");
            }

            public function getComment($statementStub, $id): Comment
            {
                throw new CommentNotFoundException("Not found");
            }
        };
    }
}
