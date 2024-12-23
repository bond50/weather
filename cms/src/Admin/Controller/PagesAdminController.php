<?php

namespace App\Admin\Controller;

use App\Admin\Support\AuthService;
use App\Repository\PagesRepository;

class PagesAdminController extends AbstractAdminController
{
    public function __construct(
        AuthService $authService,
        private PagesRepository $pagesRepository
    )
    {
        parent::__construct($authService);
    }

    public function index()
    {
        $pages = $this->pagesRepository->get();

        $this->render('pages/index', [
            'pages' => $pages
        ]);
    }

    public function create()
    {
        $errors = [];

        if (!empty($_POST)) {
            // Trim all inputs to remove leading and trailing whitespaces.
            $title = trim(@(string)$_POST['title'] ?? '');
            $content = trim(@(string)$_POST['content'] ?? '');
            $slug = trim(@(string)$_POST['slug'] ?? '');

            // Normalize the slug.
            $slug = strtolower($slug);
            $slug = str_replace(['/', ' ', '.'], '-', $slug);
            $slug = preg_replace('/[^a-z0-9\-]/', '', $slug);

            // Validate input fields.
            if (empty($title)) {
                $errors[] = "Title is required.";
            }
            if (empty($content)) {
                $errors[] = "Content is required.";
            }
            if (empty($slug)) {
                $errors[] = "Slug is required.";
            }

            // Proceed if no errors are present.
            if (empty($errors)) {
                $slugExist = $this->pagesRepository->checkIfExists($slug);
                if ($slugExist) {
                    $errors[] = "Slug already exists. Please use a different slug.";
                } else {
                    $this->pagesRepository->create($title, $content, $slug);
                    // Optionally redirect to a success page or message.
                    header("Location: index.php?route=admin/pages");
                    exit;
                }
            }
        }

        // Pass errors to the view for rendering.
        $this->render('pages/create', ['errors' => $errors]);
    }

    public function delete()
    {
        $id = @(int)($_POST['id'] ?? 0);
        if (!empty($id)) {
            $this->pagesRepository->delete($id);
        }
        header("Location: index.php?route=admin/pages");

    }

    public function edit()
    {
        $errors = [];

        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $title = isset($_POST['title']) ? trim($_POST['title']) : '';
        $content = isset($_POST['content']) ? trim($_POST['content']) : '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validation
            if (empty($title)) {
                $errors[] = "Title cannot be empty.";
            }

            if (empty($content)) {
                $errors[] = "Content cannot be empty.";
            }

            // If no errors, process the update
            if (empty($errors)) {
                $this->pagesRepository->updateTitleAndContent($id, $title, $content);
                header("Location: index.php?route=admin/pages");
                exit;
            }
        }

        // Fetch page data if ID is valid
        $page = $this->pagesRepository->fetchById($id) ?? null;

        // Handle invalid page ID
        if (!$page) {
            $errors[] = "Page not found.";
            $this->render('pages/edit', ['page' => null, 'errors' => $errors]);
            return;
        }

        $this->render('pages/edit', ['page' => $page, 'errors' => $errors]);
    }


}