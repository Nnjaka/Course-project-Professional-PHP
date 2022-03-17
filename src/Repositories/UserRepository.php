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

        return $this->getUser($statement, $id);
    }

    private function getUser(PDOStatement $statement, int $userId): User
    {
        $result = $statement->fetch(PDO::FETCH_OBJ);
        if ($result === false) {
            throw new UserNotFoundException(
                sprintf("Cannot find user with id: %s", $userId)
            );
        }

        return new User($result->first_name, $result->last_name, $result->email);
    }
}
