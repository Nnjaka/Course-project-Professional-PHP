<?php

namespace App\Classes\Comment;


interface IComment
{
    public function getId(): string;

    public function getAuthorId(): string;

    public function getArticleId(): string;

    public function getComment(): string;

    public function setAuthorId(string $authorId): void;

    public function setArticleId(string $articleId): void;

    public function setComment(string $text): void;
}