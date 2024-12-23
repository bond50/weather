<?php

namespace App\Frontend\Controller;

use App\Repository\PagesRepository;

class PagesController extends AbstractController
{
    public function __construct(PagesRepository $pagesRepository)
    {
        parent::__construct($pagesRepository);
    }

    public function showPage(string $pageKey): void{
        $page = $this->pagesRepository->fetchBySlug($pageKey);

        if (!$page) {
            $this->error404();
            return;
        }
        $this->render('pages/showPage', ['page' => $page]);

    }


}