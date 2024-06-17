<?php

// load composer autoload
require_once '../vendor/autoload.php';

// Change to application directory to execute the code
chdir(realpath(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'app'));

$GLOBALS['test_cli'] = PHP_SAPI === 'cli';

Sukarix\Statera::startCoverage('Application Bootstrapping');
$app = new Application\Application();
Sukarix\Statera::stopCoverage();
$app->start();
