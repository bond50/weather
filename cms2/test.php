<?php
header("Content-type: text/plain");
$counter = 0;
if (!empty($_COOKIE['counter'])) {
    $counter = @(int)$_COOKIE['counter'];
}
setcookie('counter', $counter + 1, time() + (86400 * 30));
var_dump($counter);
