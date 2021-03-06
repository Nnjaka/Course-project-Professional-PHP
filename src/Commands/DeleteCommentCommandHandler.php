<?php

namespace App\Commands;

use App\Connections\ConnectorInterface;
use App\Connections\SqlLiteConnector;
use App\Commands\CommandInterface;
use App\Repositories\CommentRepository;
use App\Repositories\CommentRepositoryInterface;

class DeleteCommentCommandHandler implements CommandHandlerInterface
{
    private \PDOStatement|false $stmt;

    public function __construct(
        private ?CommentRepositoryInterface $articleRepository = null,
        private ?ConnectorInterface $connector = null
    ) {
        $this->commentRepository = $commentRepository ?? new CommentRepository();
        $this->connector = $connector ?? new SqlLiteConnector();
        $this->stmt = $this->connector->getConnection()->prepare($this->getSQL());
    }

    /**
     * @var DeleteEntityCommand $command
     */
    public function handle(CommandInterface $command): void
    {
        $id = $command->getId();
        $this->stmt->execute(
            [
                ':id' => (string)$id
            ]
        );
    }


    public function getSQL(): string
    {
        return "DELETE FROM comments WHERE id = :id";
    }
}
