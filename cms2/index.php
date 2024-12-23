<?php

use App\Frontend\Controller\NotFoundController;
use App\Frontend\Controller\PagesController;
use App\Repository\PagesRepository;

require __DIR__ . '/inc/all.inc.php';


$route = @$_GET['route'] ?? 'pages';



if ($route == 'pages') {
    $page = @(string)$_GET['page'] ?? 'index';



    $pagesRepository = new PagesRepository($pdo);



    $pagesRepository->fetchBySlug($page);



    $pagesController = new PagesController($pagesRepository);
    $pagesController->showPage($page);



} else {

    $pagesRepository = new PagesRepository($pdo);
    $notFoundController = new NotFoundController($pagesRepository);
    $notFoundController->error404();


}


