<?php

require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__."/../");
$dotenv->load();
session_start();


// Instantiate the app
$settings = require  '../config/settings.php';
$app = new Slim\App($settings);

// Set up dependencies
require 'dependencies.php';

// Register middleware
require  'middleware.php';

// Register routes
require  '../app/Routes/routes.php';

// Run app
$app->run();
