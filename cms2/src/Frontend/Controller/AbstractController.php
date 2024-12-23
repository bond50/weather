<?php

namespace App\Frontend\Controller;

use App\Repository\PagesRepository;

abstract class AbstractController
{

    public function __construct(protected PagesRepository $pagesRepository)
    {
    }

    protected function render(string $view, array $params = []): void
    {
        extract($params);
        ob_start();
        include __DIR__ . "/../../../views/frontend/" . $view . ".view.php";
        $content = ob_get_clean();
        $navigation = $this->pagesRepository->fetchForNavigation();
        include __DIR__ . "/../../../views/frontend/layouts/main.view.php";

    }



    protected function error404(): void
    {
        http_response_code(404);
        $this->render('abstract/error404', []);
    }
}
