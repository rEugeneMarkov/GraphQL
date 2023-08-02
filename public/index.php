<?php

require_once '../vendor/autoload.php';

use App\Core\Environment;

Environment::init();

require dirname(__DIR__) . '/app/core/router.php';
