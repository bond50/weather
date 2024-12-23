<?php
use App\Admin\Controller\LoginController;
use App\Admin\Controller\PagesAdminController;
use App\Admin\Support\AuthService;
use App\Frontend\Controller\PagesController;
use App\Repository\PagesRepository;
use App\Frontend\Controller\NotFoundController;
use App\Support\Container;
use App\Support\CsrfHelper;
use App\Support\CsrfValidationException;

require __DIR__ . '/inc/all.inc.php';

$container = new Container();

// Dependency Bindings
$container->bind('pdo', function () {
    return require __DIR__ . '/inc/db-connect.inc.php';
});

$container->bind('pagesRepository', function () use ($container) {
    $pdo = $container->get('pdo');
    return new PagesRepository($pdo);
});

$container->bind('csrfHelper', function () use ($container) {
    return new CsrfHelper();
});

$container->bind('pagesController', function () use ($container) {
    $pagesRepository = $container->get('pagesRepository');
    return new PagesController($pagesRepository);
});

$container->bind('notFoundController', function () use ($container) {
    $pagesRepository = $container->get('pagesRepository');
    return new NotFoundController($pagesRepository);
});

$container->bind('authService', function () use ($container) {
    $pdo = $container->get('pdo');
    return new AuthService($pdo);
});

$container->bind('loginController', function () use ($container) {
    $authService = $container->get('authService');
    return new LoginController($authService);
});

$container->bind('pagesAdminController', function () use ($container) {
    $pagesRepository = $container->get('pagesRepository');
    $authService = $container->get('authService');
    return new PagesAdminController($authService, $pagesRepository);
});

// CSRF Helper instance
$csrfHelper = $container->get('csrfHelper');

try {
    // Handle CSRF validation for all POST requests
    $csrfHelper->handle();
} catch (CsrfValidationException $e) {
    // Return a simple error message for invalid CSRF
    http_response_code(419);
    echo "Error: Invalid CSRF";
    exit;
}

// CSRF Token Generator
function csrf_token(): string
{
    global $container;
    $csrfHelper = $container->get('csrfHelper');
    return $csrfHelper->generateToken();
}

// Routing Logic
$route = $_GET['route'] ?? 'pages';

if ($route === 'pages') {
    $page = $_GET['page'] ?? 'index';
    $pagesController = $container->get('pagesController');
    $pagesController->showPage($page);

} elseif ($route === 'admin/pages/create') {
    $authService = $container->get('authService');
    $authService->ensureLoggedIn();
    $pagesAdminController = $container->get('pagesAdminController');
    $pagesAdminController->create();
} elseif ($route === 'admin/login') {
    $pagesAdminController = $container->get('loginController');
    $pagesAdminController->login();
} elseif ($route === 'admin/logout') {
    $loginController = $container->get('loginController');
    $loginController->logout();

} elseif ($route === 'admin/pages/delete') {
    $authService = $container->get('authService');
    $authService->ensureLoggedIn();
    $pagesAdminController = $container->get('pagesAdminController');
    $pagesAdminController->delete();
} elseif ($route === 'admin/pages/edit') {
    $authService = $container->get('authService');
    $authService->ensureLoggedIn();
    $pagesAdminController = $container->get('pagesAdminController');
    $pagesAdminController->edit();

} elseif ($route === 'admin/pages') {
    $authService = $container->get('authService');
    $authService->ensureLoggedIn();
    $pagesAdminController = $container->get('pagesAdminController');
    $pagesAdminController->index();
} else {
    $pagesRepository = $container->get('pagesRepository');
    $notFoundController = $container->get('notFoundController');
    $notFoundController->error404();
}
