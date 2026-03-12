<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->loadEnv(dirname(__DIR__) . '/.env.dev');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);