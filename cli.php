<?php

include_once "vendor/autoload.php";

use App\Classes\Article\Article;
use App\Classes\User\User;
use App\Classes\Comment\Comment;
use App\Repositories\ArticleRepository;
use App\Repositories\UserRepository;
use App\Repositories\CommentRepository;

$userRepository = new UserRepository();
$userRepository->save(new User('Irina', 'Vinter', 'vinter@ya.ru'));
$userRepository->delete(1);

$articleRepository = new ArticleRepository();
$articleRepository->save(new Article(2, 'New header', 'Some text'));
$articleRepository->delete(1);

$commentRepository = new CommentRepository();
$commentRepository->save(new Comment(1, 1, 'Some comment'));
$commentRepository->delete(1);
