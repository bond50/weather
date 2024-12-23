<?php

namespace App\Repository;

use App\Frontend\Controller\PagesController;
use App\Model\PageModel;
use PDO;

class PagesRepository
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function fetchForNavigation(): array
    {
        return $this->get();
    }

    public function get(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `pages` ORDER BY `id` ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, PageModel::class);
    }


    public function fetchBySlug(string $slug): ?PageModel
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `pages` WHERE `slug` = :slug");
        $stmt->bindValue(':slug', $slug);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, PageModel::class);
        $entry = $stmt->fetch();
        if (!empty($entry)) {
            return $entry;
        } else {
            return null;
        }
    }

    public function checkIfExists(string $slug): bool
    {

        $stmt = $this->pdo->prepare("SELECT COUNT(*) AS `count` FROM `pages` WHERE `slug` = :slug");

        $stmt->bindValue(':slug', $slug);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;

    }

    public function create(string $title, string $content, string $slug)
    {

        $stmt = $this->pdo->prepare('INSERT INTO `pages` (`title`, `content`, `slug`) VALUES (:title, :content, :slug)');
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':content', $content);
        $stmt->bindValue(':slug', $slug);
        return $stmt->execute();
    }

    public function delete(int $id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM `pages` WHERE `id` = :id");
        $stmt->bindValue(':id', $id , PDO::PARAM_INT);
        return $stmt->execute();
    }


    public function fetchById(int $id): ?PageModel
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `pages` WHERE `id` = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, PageModel::class);
        $entry = $stmt->fetch();
        if (!empty($entry)) {
            return $entry;
        } else {
            return null;
        }
    }

    public function updateTitleAndContent(int $id, string $title, string $content)
    {
        $stmt = $this->pdo->prepare('UPDATE `pages` SET `title` = :title, `content` = :content WHERE `id` = :id');
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':content', $content);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

}