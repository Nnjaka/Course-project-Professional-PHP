<?php

namespace Test\Commands;

use App\Classes\User\User;
use App\Commands\DeleteUserCommandHandler;
use App\Commands\DeleteEntityCommand;
use App\Connections\ConnectorInterface;
use App\Repositories\UserRepository;
use App\Connections\SqlLiteConnectorInterface;
use PDOStatement;
use App\config\SqlLiteConfig;
use PHPUnit\Framework\TestCase;

class DeleteUserCommandTest extends TestCase
{
    public function testItDeleteUserFromDatabase(): void
    {
        $connectionStub = $this->createStub(SqlLiteConnectorInterface::class);
        $statementMock = $this->createMock(PDOStatement::class);

        $statementMock
            ->method('execute')
            ->with([
                ':id' => 3,
            ]);

        $connectionStub->method('getConnection')->willReturn(new \PDO(SqlLiteConfig::DSN));
        $this->assertInstanceOf(SqlLiteConnectorInterface::class, $connectionStub);

        $repository = new UserRepository($connectionStub);

        $createUserCommandHandler = new DeleteUserCommandHandler($repository, $connectionStub);

        $command = new DeleteEntityCommand(3);

        $createUserCommandHandler->handle($command);
    }
}
