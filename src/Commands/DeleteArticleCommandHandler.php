<?php

namespace App\Commands;

use App\Connections\ConnectorInterface;
use App\Connections\SqlLiteConnector;
use App\Commands\CommandInterface;
use App\Repositories\ArticleRepository;
use App\Repositories\ArticleRepositoryInterface;

class DeleteArticleCommandHandler implements CommandHandlerInterface
{
    private \PDOStatement|false $stmt;

    public function __construct(
        private ?ArticleRepositoryInterface $articleRepository = null,
        private ?ConnectorInterface $connector = null
    ) {
        $this->articleRepository = $articleRepository ?? new ArticleRepository();
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
        return "DELETE FROM articles WHERE id = :id";
    }
}
