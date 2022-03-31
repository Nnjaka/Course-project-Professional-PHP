<?php

namespace App\Http\Actions;

use App\Commands\CreateArticleCommandHandler;
use App\Commands\CreateEntityCommand;
use App\Classes\Article\Article;
use App\Exceptions\HttpException;
use App\Exceptions\ArticleIdExistException;
use App\Http\Actions\ActionInterface;
use App\Http\ErrorResponse;
use App\Http\Request;
use App\Http\Response;
use App\Http\SuccessfulResponse;

class CreateArticle implements ActionInterface
{
    public function __construct(
        private ?CreateArticleCommandHandler $createArticleCommandHandler = null
    ) {
        $this->createArticleCommandHandler = $createArticleCommandHandler ?? new CreateArticleCommandHandler();
    }

    public function handle(Request $request): Response
    {
        try {
            $article = new Article(
                $request->jsonBodyField('authorId'),
                $request->jsonBodyField('header'),
                $request->jsonBodyField('text')
            );

            $this->createArticleCommandHandler->handle(new CreateEntityCommand($article));
        } catch (HttpException | ArticleIdExistException $exception) {
            return new ErrorResponse($exception->getMessage());
        }

        return new SuccessfulResponse(
            [
                'id' => $article->getId(),
            ]
        );
    }
}
