<?php

namespace App\Commands;

use App\Connections\ConnectorInterface;
use App\Connections\SqlLiteConnector;
use App\Commands\CommandInterface;
use App\Commands\CreateEntityCommand;
use App\Exceptions\ArticleNotFoundException;
use App\Exceptions\ArticleIdExistException;
use App\Repositories\ArticleRepository;
use App\Repositories\ArticleRepositoryInterface;

class CreateArticleCommandHandler implements CommandHandlerInterface
{
    private \PDOStatement|false $stmt;

    public function __construct(
        private ?ArticleRepositoryInterface $articleRepository = null,
        private ?ConnectorInterface $connector = null
    ) {
        $this->userRepository = $articleRepository ?? new ArticleRepository();
        $this->connector = $connector ?? new SqlLiteConnector();
        $this->stmt = $this->connector->getConnection()->prepare($this->getSQL());
    }

    /**
     * @var CreateEntityCommand $command
     */
    public function handle(CommandInterface $command): void
    {
        $article = $command->getEntity();
        $id = $article->getId();

        if (!$this->isArticleExists($id)) {
            $this->stmt->execute(
                [
                    ':author_id' => $article->getAuthorId(),
                    ':header' => $article->getHeader(),
                    ':text' => $article->getText(),
                ]
            );
        } else {
            throw new ArticleIdExistException();
        }
    }

    private function isArticleExists(int $id): bool
    {
        try {
            $this->articleRepository->get($id);
        } catch (ArticleNotFoundException) {
            return false;
        }

        return true;
    }

    public function getSQL(): string
    {
        return "INSERT INTO articles (author_id, header, text) 
        VALUES (:author_id, :header, :text)";
    }
}
