<?php

namespace App\Commands;

use App\Connections\ConnectorInterface;
use App\Connections\SqlLiteConnector;
use App\Commands\CommandInterface;

class CreateUserCommandHandler implements CommandHandlerInterface
{
    private \PDOStatement|false $stmt;

    public function __construct(private ?ConnectorInterface $connector = null)
    {
        $this->connector = $connector ?? new SqlLiteConnector();
        $this->stmt = $this->connector->getConnection()->prepare($this->getSQL());
    }

    /**
     * @var CreateEntityCommand $command
     */
    public function handle(CommandInterface $command): void
    {
        $user = $command->getEntity();
        $this->stmt->execute(
            [
                ':first_name' => $user->getFirstName(),
                ':last_name' => $user->getLastName(),
                ':email' => $user->getEmail(),
            ]
        );
    }

    public function getSQL(): string
    {
        return "INSERT INTO users (first_name, last_name, email) 
        VALUES (:first_name, :last_name, :email)";
    }
}
