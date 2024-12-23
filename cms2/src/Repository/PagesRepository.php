<?php
namespace App\Repository;
use App\Model\PageModel;
use PDO;

class PagesRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function fetchForNavigation(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `pages`");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, PageModel::class);
    }

    public function fetchBySlug(string $pageKey): ?PageModel{
        $stmt = $this->pdo->prepare("SELECT * FROM `pages` WHERE `slug` = :slug");
        $stmt->bindValue(':slug', $pageKey);
        $stmt->execute();
        return $stmt->fetchObject(PageModel::class) ?: null;
    }


}