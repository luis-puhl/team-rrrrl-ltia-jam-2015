<?php
require 'Slim-2.6.2/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$projectDir = '.';

session_cache_limiter(false);
session_start();

require "$projectDir/includes.php";     //include the file which contains all the project related includes

$app = new \Slim\Slim(array(
    'debug' => true,
    'user.user' => 'jamUser',
	'user.pass' => 'lepass',
	'mode' => 'development',
	'templates.path' => 'views'
));

$app->response->headers->set('Content-Type', 'application/json');

$dbo = new PDO('mysql:host=localhost;dbname=jam', 
	$app->config('user.user'), 
	$app->config('user.pass')
);

require "$projectDir/routes.php"; 

$app->run();