<?php

namespace App\Classes\Comment;


class Comment implements IComment
{
    private string $id;
    private string $authorId;
    private string $articleId;
    private string $comment;

    public function __construct(string $authorId, string $articleId, string
    $comment)
    {
        $this->id = uniqid();
        $this->setAuthorId($authorId);
        $this->setArticleId($articleId);
        $this->setComment($comment);
    }

    public function getId(): ?int
    {
        return (int)$this->id;
    }

    public function getAuthorId(): string
    {
        return $this->authorId;
    }

    public function getArticleId(): string
    {
        return $this->articleId;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setAuthorId(string $authorId): void
    {
        // Какая то логика
        $this->authorId = $authorId;
    }

    public function setArticleId(string $articleId): void
    {
        // Какая то логика
        $this->articleId = $articleId;
    }

    public function setComment(string $text): void
    {
        // Какая то логика
        $this->comment = $text;
    }

    public function __toString(): string
    {
        return "Id: $this->id\nId автора: $this->authorId\n" .
            "Id статьи: $this->articleId\nКомментарий: $this->comment\n\n";
    }
}
