<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./styles/simple.css"/>
    <link rel="stylesheet" type="text/css" href="./styles/admin.css"/>
    <link rel="stylesheet" type="text/css" href="./styles/custom.css"/>
    <title>CMS Project</title>
</head>
<body>
<header>
    <h1>
        <a href="index.php?page=index">CMS Admin</a>
    </h1>
    <p>An amzing admin area</p>
    <nav>
        <?php if (!empty($isLoggedIn)) : ?>
            <a href="index.php? <?= http_build_query(['route' => 'admin/logout']) ?>">
                Logout
            </a>
        <?php endif; ?>


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