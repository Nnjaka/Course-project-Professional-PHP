<?php

namespace App\Http\Actions;

use App\Commands\CreateCommentCommandHandler;
use App\Commands\CreateEntityCommand;
use App\Classes\Comment\Comment;
use App\Exceptions\HttpException;
use App\Exceptions\CommentIdExistException;
use App\Http\Actions\ActionInterface;
use App\Http\ErrorResponse;
use App\Http\Request;
use App\Http\Response;
use App\Http\SuccessfulResponse;

class CreateComment implements ActionInterface
{
    public function __construct(
        private ?CreateCommentCommandHandler $createCommentCommandHandler = null
    ) {
        $this->createCommentCommandHandler = $createCommentCommandHandler ?? new CreateCommentCommandHandler();
    }

    public function handle(Request $request): Response
    {
        try {
            $comment = new Comment(
                $request->jsonBodyField('authorId'),
                $request->jsonBodyField('articleId'),
                $request->jsonBodyField('comment')
            );

            $this->createCommentCommandHandler->handle(new CreateEntityCommand($comment));
        } catch (HttpException | CommentIdExistException $exception) {
            return new ErrorResponse($exception->getMessage());
        }

        return new SuccessfulResponse(
            [
                'id' => $comment->getId(),
            ]
        );
    }
}
