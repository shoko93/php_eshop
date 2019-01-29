<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/connection.php';
require_once __DIR__ . '/constants.php';
require_once __DIR__ . '/function.php';
require_once __DIR__ . '/header.php';

$dotenv = new Dotenv\Dotenv(__DIR__);

if (getenv('APP_ENV') != 'production') {
    // Use $dotenv->overload() to overload env variables.
    $dotenv->load();
}

$dotenv->required([
    'SMTP_USERNAME', 'SMTP_PASSWORD', 'SMTP_FROM', 'MAILTO_EMAIL', 'MAILTO_NAME'
]);
