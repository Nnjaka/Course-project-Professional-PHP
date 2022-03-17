<?php

include_once "vendor/autoload.php";

use App\Classes\Article\Article;
use App\Classes\User\User;
use App\Classes\Comment\Comment;
use App\Managers\EntityManager;

$entityManager = new EntityManager();

$entityManager->createCommandHandler(new User('Irina', 'Vinter', 'vinter@ya.ru'));
$entityManager->createCommandHandler(new Article(3, 'New header', 'Any text'));
$entityManager->createCommandHandler(new Comment(5, 2, 'Some comment'));

$entityManager->deleteCommandHandler('user', 6);
$entityManager->deleteCommandHandler('article', 6);
$entityManager->deleteCommandHandler('comment', 6);
