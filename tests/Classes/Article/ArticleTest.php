<?php

namespace Test\Classes\Article;

use App\Classes\Article\Article;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    private Article $article;

    public function getArticle(): Article
    {
        return  $this->article =  $article ?? new Article(1, 'Some header', 'Some text');
    }

    public function testInstanceOfArticle()
    {
        $this->assertInstanceOf(Article::class, $this->getArticle());
    }

    public function testItTypeOfAuthorId()
    {
        $this->assertIsString($this->getArticle()->getAuthorId());
    }

    public function testItTypeOfHeader()
    {
        $this->assertIsString($this->getArticle()->getHeader());
    }

    public function testItTypeOfText()
    {
        $this->assertIsString($this->getArticle()->getText());
    }

    public function testItGetAuthorId()
    {
        $argument = '1';
        $authorId = $this->getArticle()->getAuthorId();
        $this->assertSame($authorId, $argument);
    }

    public function testItGetHeader()
    {
        $argument = 'Some header';
        $header = $this->getArticle()->getHeader();
        $this->assertSame($header, $argument);
    }

    public function testItGetText()
    {
        $argument = 'Some text';
        $text = $this->getArticle()->getText();
        $this->assertSame($text, $argument);
    }

    public function testItSetAuthorId()
    {
        $argument = '5';
        $this->getArticle()->setAuthorId($argument);
        $this->assertSame($this->article->getAuthorId(), $argument);
    }

    public function testItSetHeader()
    {
        $argument = 'Other header';
        $this->getArticle()->setHeader($argument);
        $this->assertSame($this->article->getHeader(), $argument);
    }

    public function testItSetText()
    {
        $argument = 'Other text';
        $this->getArticle()->setText($argument);
        $this->assertSame($this->article->getText(), $argument);
    }
}
