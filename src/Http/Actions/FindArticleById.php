<?php

namespace App\Http\Actions;

use App\Exceptions\HttpException;
use App\Exceptions\ArticleNotFoundException;
use App\Http\ErrorResponse;
use App\Http\Request;
use App\Http\Response;
use App\Http\SuccessfulResponse;
use App\Repositories\ArticleRepository;
use App\Repositories\ArticleRepositoryInterface;

class FindArticleById implements ActionInterface
{
    public function __construct(private ?ArticleRepositoryInterface $articleRepository = null)
    {
        $this->articleRepository = $this->articleRepository ?? new ArticleRepository();
    }

    public function handle(Request $request): Response
    {
        try {
            $id = $request->query('id');
        } catch (HttpException $e) {
            return new ErrorResponse($e->getMessage());
        }

        try {
            $article = $this->articleRepository->get($id);
        } catch (ArticleNotFoundException $e) {
            return new ErrorResponse($e->getMessage());
        }

        return new SuccessfulResponse([
            'id' => $article->getId(),
            'header' => $article->getHeader(),
        ]);
    }
}
