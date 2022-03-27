<?php

namespace App\Repositories;

use App\Classes\User\User;
use App\Exceptions\UserNotFoundException;
use PDO;
use PDOStatement;
use App\Repositories\EntityRepository;

class UserRepository extends EntityRepository implements UserRepositoryInterface
{
    /**
     * @throws \Exception
     */
    public function get(int $id): User
    {
        $statement = $this->connector->getConnection()->prepare(
            'SELECT * FROM users WHERE id = :id'
        );

        $statement->execute([
            ':id' => (string)$id,
        ]);

        return $this->getUser($statement);
    }

    /**
     * @throws UserNotFoundException
     */
    public function getUserByEmail(string $email): User
    {
        $statement = $this->connector->getConnection()->prepare(
            'SELECT * FROM users WHERE email = :email'
        );

        $statement->execute([
            ':email' => $email,
        ]);

        return $this->getUser($statement);
    }

    public function getUser(PDOStatement $statement): User
    {
        $userData = $statement->fetch(PDO::FETCH_OBJ);

        if (!$userData) {
            throw new UserNotFoundException('Пользователь не найден');
        }

        return
            new User(
                $userData->first_name,
                $userData->last_name,
                $userData->email
            );
    }
}
