<?php

namespace App\Classes\Article;

use App\Classes\EntityInterface;

interface IArticle extends EntityInterface
{
    public function getId(): ?int;

    public function getAuthorId(): string;

    public function getHeader(): string;

    public function getText(): string;

    public function setAuthorId(string $authorId): void;

    public function setHeader(string $header): void;

    public function setText(string $text): void;
}
