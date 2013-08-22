<?php

// Composer autoloader from this application
$sAutoloadFile = __DIR__.'/../vendor/autoload.php';
if (!is_file($sAutoloadFile)) {

// Composer autoloader from the main application
$sAutoloadFile = __DIR__.'/../../../autoload.php';
if (!is_file($sAutoloadFile)) {
throw new \LogicException('Run "composer install --dev" to create autoloader.');
}
}
require_once($sAutoloadFile);

error_reporting(-1);
