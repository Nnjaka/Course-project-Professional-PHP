<?php

namespace App\Commands;

use App\Connections\ConnectorInterface;
use App\Connections\SqlLiteConnector;
use App\Commands\CommandInterface;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;


class DeleteUserCommandHandler implements CommandHandlerInterface
{
    private \PDOStatement|false $stmt;

    public function __construct(
        private ?UserRepositoryInterface $userRepository = null,
        private ?ConnectorInterface $connector = null
    ) {
        $this->userRepository = $userRepository ?? new UserRepository();
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
        return "DELETE FROM users WHERE id = :id";
    }
}
