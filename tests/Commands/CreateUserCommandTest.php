<?php

namespace Test\Commands;

use App\Classes\User\User;
use App\Commands\CreateEntityCommand;
use App\Commands\CreateUserCommandHandler;
use App\Connections\ConnectorInterface;
use App\Exceptions\UserEmailExistException;
use App\Repositories\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;

class CreateUserCommandTest extends TestCase
{
    public function testItThrowsAnExceptionWhenUserAlreadyExists()
    {
        $connectionStub = $this->createStub(ConnectorInterface::class);
        $userRepositoryStub = $this->createStub(UserRepositoryInterface::class);
        $createUserCommandHandler = new CreateUserCommandHandler($userRepositoryStub, $connectionStub);

        $this->expectException(UserEmailExistException::class);
        $this->expectExceptionMessage('Пользователь с таким email уже существует в системе');

        $command = new CreateEntityCommand(
            new User(
                'Irina',
                'Vinter',
                'vinter@ya.ru'
            )
        );

        $createUserCommandHandler->handle($command);
    }
}
