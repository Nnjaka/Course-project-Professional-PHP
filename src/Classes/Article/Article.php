<?php

namespace App\Classes\Article;


class Article implements IArticle
{
    private string $id;
    private string $authorId;
    private string $header;
    private string $text;

    public function __construct(string $authorId, string $header, string $text)
    {
        $this->id = uniqid();

        $this->setAuthorId($authorId);
        $this->setHeader($header);
        $this->setText($text);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getAuthorId(): string
    {
        return $this->authorId;
    }

    public function getHeader(): string
    {
        return $this->header;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setAuthorId(string $authorId): void
    {
        // Здесь какая нибудь логика
        $this->authorId = $authorId;
    }

    public function setHeader(string $header): void
    {
        // Здесь какая нибудь логика
        $this->header = $header;
    }

    public function setText(string $text): void
    {
        // Здесь какая нибудь логика
        $this->text = $text;
    }

    public function __toString(): string
    {
        return "Id: $this->id\nId автора: $this->authorId\n" .
            "Заголовок: $this->header\nТекст: $this->text\n\n";
    }
}