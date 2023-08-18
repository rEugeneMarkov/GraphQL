<?php

require_once '../vendor/autoload.php';

use App\Core\Environment;

Environment::init();

$container = require __DIR__ . '/../app/core/bootstrap/bootstrap.php';

require dirname(__DIR__) . '/app/core/router.php';
