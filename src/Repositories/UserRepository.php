<?php

namespace App\Repositories;

use App\Classes\User\User;
use App\Exceptions\UserNotFoundException;
use PDO;
use PDOStatement;
use App\Repositories\EntityRepository;
use App\Classes\EntityInterface;


class UserRepository extends EntityRepository implements UserRepositoryInterface
{
    /**
     * @param EntityInterface $entity
     * @return void
     */
    public function save(EntityInterface $entity): void
    {
        /**
         * @var User $entity
         */
        $statement =  $this->connector->getConnection()
            ->prepare("INSERT INTO users (first_name, last_name, email) 
                VALUES (:first_name, :last_name, :email)");

        $statement->execute(
            [
                ':first_name' => $entity->getFirstName(),
                ':last_name' => $entity->getLastName(),
                ':email' => $entity->getEmail(),
            ]
        );
    }


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

    public function delete(int $id): void
    {
        $statement = $this->connector->getConnection()->prepare(
            'DELETE FROM users WHERE id = :id'
        );

        $statement->execute(
            [
                ':id' => (string)$id
            ]
        );
    }
}
