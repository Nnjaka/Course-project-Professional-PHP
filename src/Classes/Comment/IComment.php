<?php

namespace App\Classes\Comment;

use App\Classes\EntityInterface;

interface IComment extends EntityInterface
{
    public function getId(): ?int;

    public function getAuthorId(): string;

    public function getArticleId(): string;

    public function getComment(): string;

    public function setAuthorId(string $authorId): void;

    public function setArticleId(string $articleId): void;

    public function setComment(string $text): void;
}
