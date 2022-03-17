<?php

namespace App\Repositories;

use App\Classes\Comment\Comment;
use App\Repositories\CommentRepositoryInterface;
use App\Exceptions\CommentNotFoundException;
use PDOStatement;
use PDO;
use App\Repositories\EntityRepository;

class CommentRepository extends EntityRepository implements CommentRepositoryInterface
{
    public function get(int $id): Comment
    {
        $statement = $this->connector->getConnection()
            ->prepare("SELECT * FROM comments WHERE id=:id");
        $statement->execute(
            [
                ':id' => (string)$id
            ]
        );

        return $this->getComment($statement, $id);
    }

    public function getComment(PDOStatement $statement, int $id): Comment
    {
        $result = $statement->fetch(PDO::FETCH_OBJ);
        if ($result === false) {
            throw new CommentNotFoundException(
                printf("Cannot find comment with id: %s", $id)
            );
        }

        return new Comment($result->authorId, $result->articleId, $result->comment);
    }
}
