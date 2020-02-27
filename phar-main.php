<?php

if ('cli' === PHP_SAPI) {
    require_once 'public/console.php';

    return;
}
require_once 'public/index.php';
