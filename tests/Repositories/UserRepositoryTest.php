<?php

namespace Test\Repositories;

use App\Connections\SqlLiteConnectorInterface;
use App\Repositories\UserRepository;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\UserEmailExistException;
use App\Commands\CreateEntityCommand;
use App\Commands\CreateUserCommandHandler;
use App\Classes\User\User;
use PDOStatement;
use App\config\SqlLiteConfig;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    public function testItThrowsAnExceptionWhenUserNotFound()
    {
        $connectionStub = $this->createStub(SqlLiteConnectorInterface::class);

        $statementStub = $this->createStub(PDOStatement::class);
        $statementStub->method('fetch')->willReturn(false);

        $repository = new UserRepository($connectionStub);

        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage('Пользователь не найден');

        $repository->getUser($statementStub);
    }

    public function testItSavesUserToDatabase(): void
    {
        $connectionStub = $this->createStub(SqlLiteConnectorInterface::class);
        $statementMock = $this->createMock(PDOStatement::class);

        $statementMock
            ->method('execute')
            ->with([
                ':email' => 'vinter@ya.ru',
            ]);

        $connectionStub->method('getConnection')->willReturn(new \PDO(SqlLiteConfig::DSN));
        $this->assertInstanceOf(SqlLiteConnectorInterface::class, $connectionStub);

        $repository = new UserRepository($connectionStub);

        $this->expectException(UserEmailExistException::class);
        $this->expectExceptionMessage('Пользователь с таким email уже существует в системе');

        $createCommentCommandHandler = new CreateUserCommandHandler($repository, $connectionStub);

        $command = new CreateEntityCommand(
            new User('Irina', 'Vinter', 'vinter@ya.ru')
        );
        $createCommentCommandHandler->handle($command);
    }
}
