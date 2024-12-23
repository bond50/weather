<?php

function e($value)
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
/*
function render($view, $params = [])
{
    extract($params);
    ob_start();
    include __DIR__ . "/../views/frontend/pages/$view.php";
    $content = ob_get_clean();
    ob_get_clean();
    include __DIR__ . "/../views/frontend/layouts/main.view.php";
}
*/