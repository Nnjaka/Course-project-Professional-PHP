<?php

include_once "vendor/autoload.php";

use App\Classes\Article\Article;
use App\Classes\User\User;
use App\Classes\Comment\Comment;
use App\Managers\EntityManager;

$user = new User('Irina', 'Vinter', 'vinter@ya.ru');
$article = new Article(3, 'New header', 'Some text');
$comment = new Comment(1, 2, 'Some comment');

$entityManager = new EntityManager();

$entityManager->save($user);
$entityManager->save($article);
$entityManager->save($comment);

$entityManager->delete('User', 3);
$entityManager->delete('article', 3);
$entityManager->delete('COMMENT', 3);
