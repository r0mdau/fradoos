<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
date_default_timezone_set('UTC');

require_once __DIR__ . '/../vendor/autoload.php';

$_SERVER["APP_ENV"] = $_SERVER["APP_ENV"] ?? "development";