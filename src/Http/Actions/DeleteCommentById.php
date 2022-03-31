<?php

namespace App\Http\Actions;

use App\Http\Actions\ActionInterface;
use App\Exceptions\HttpException;
use App\Exceptions\CommentNotFoundException;
use App\Http\ErrorResponse;
use App\Http\SuccessfulResponse;
use App\Http\Request;
use App\Http\Response;
use App\Managers\EntityManager;

class DeleteCommentById implements ActionInterface
{
    public function __construct(
        private ?EntityManager $entityManager = null
    ) {
        $this->entityManager = $this->entityManager ?? new EntityManager();
    }

    public function handle(Request $request): Response
    {
        try {
            $id = $request->query('id');
            $this->entityManager->deleteCommandHandler('comment', $id);
        } catch (HttpException | CommentNotFoundException $e) {
            return new ErrorResponse($e->getMessage());
        }

        return new SuccessfulResponse([
            'id' => $id,
        ]);
    }
}
