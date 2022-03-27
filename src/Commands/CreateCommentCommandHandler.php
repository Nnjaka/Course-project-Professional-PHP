<?php

namespace App\Commands;

use App\Connections\ConnectorInterface;
use App\Connections\SqlLiteConnector;
use App\Commands\CommandInterface;
use App\Commands\CreateEntityCommand;
use App\Repositories\CommentRepositoryInterface;
use App\Exceptions\CommentIdExistException;
use App\Exceptions\CommentNotFoundException;


class CreateCommentCommandHandler implements CommandHandlerInterface
{
    private \PDOStatement|false $stmt;

    public function __construct(
        private CommentRepositoryInterface $commentRepository,
        private ?ConnectorInterface $connector = null,
    ) {
        $this->connector = $connector ?? new SqlLiteConnector();
        $this->stmt = $this->connector->getConnection()->prepare($this->getSQL());
    }

    /**
     * @var CreateEntityCommand $command
     */
    public function handle(CommandInterface $command): void
    {
        $comment = $command->getEntity();
        $id = $comment->getId();

        if (!$this->isCommentExists($id)) {
            $this->stmt->execute(
                [
                    ':author_id' => $comment->getAuthorId(),
                    ':article_id' => $comment->getArticleId(),
                    ':comment' => $comment->getComment(),
                ]
            );
        } else {
            throw new CommentIdExistException();
        }
    }

    private function isCommentExists(int $id): bool
    {
        try {
            $this->commentRepository->get($id);
        } catch (CommentNotFoundException) {
            return false;
        }

        return true;
    }

    public function getSQL(): string
    {
        return "INSERT INTO comments(author_id, article_id, comment) 
        VALUES (:author_id, :article_id, :comment)";
    }
}
