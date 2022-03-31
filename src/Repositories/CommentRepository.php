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
        if (!$result) {
            throw new CommentNotFoundException('Комментарий не найден');
        }
        return new Comment($result->author_id, $result->article_id, $result->comment);
    }
}
