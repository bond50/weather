<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./styles/simple.css"/>
    <link rel="stylesheet" type="text/css" href="./styles/custom.css"/>
    <title>CMS Project</title>
</head>
<body>
<header>
    <h1>
        <a href="index.php?page=index">CMS Project</a>
    </h1>
    <p>A custom-made CMS system</p>
    <nav>

        <?php use App\Model\PageModel;

        foreach ($navigation as $p): ?>
            <a href="index.php?<?= http_build_query(['page' => $p->slug]) ?>"
                <?php if (!empty($page) && !empty($page->id) && $page instanceof PageModel && $p->id ===$page->id): ?>
                class="active"
                <?php endif; ?>
            >
                <?= e($p->title) ?>
            </a>
        <?php endforeach; ?>


    </nav>

</header>
<main>
    <?php echo $contents; ?>
</main>
<footer>
    <p></p>
</footer>
</body>
</html>