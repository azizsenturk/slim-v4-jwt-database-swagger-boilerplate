<?php

declare (strict_types = 1);

use Core\Middleware\ResponseEmitter;
use DI\ContainerBuilder;
use Selective\BasePath\BasePathMiddleware;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;
use Utils\Handlers\HttpErrorHandler;
use Utils\Handlers\ShutdownHandler;

define('WORK_IN_LOCALHOST', (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false));

define('APP_ROOT', dirname(__DIR__));
require APP_ROOT . '/vendor/autoload.php';

// Load environment variables
$envFileName = WORK_IN_LOCALHOST ? '.env.local' : '.env';
$dotenv = Dotenv\Dotenv::createImmutable(APP_ROOT, $envFileName);
if (file_exists(APP_ROOT . '/' . $envFileName)) {
    $dotenv->safeLoad();
}

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

// Set up settings
$settings = require APP_ROOT . '/src/Core/Config/Definations.php';
$settings($containerBuilder);

error_reporting(SHOW_ERROR_REPORTING === 'true' ? -1 : 0);

// Set up dependencies
$dependencies = require APP_ROOT . '/src/Core/Config/Dependencies.php';
$dependencies($containerBuilder);

// Set up repositories
$repositories = require APP_ROOT . '/src/Core/Config/Repositories.php';
$repositories($containerBuilder);

// Build PHP-DI Container instance
$container = $containerBuilder->build();

// Instantiate the app
AppFactory::setContainer($container);
$app = AppFactory::create();
$callableResolver = $app->getCallableResolver();

$app->add(new BasePathMiddleware($app));

// Register middleware
$middleware = require APP_ROOT . '/src/Core/Config/Middleware.php';
$middleware($app);

// Register routes
$routes = require APP_ROOT . '/src/Core/Config/Routes.php';
$routes($app);

// Create Request object from globals
$serverRequestCreator = ServerRequestCreatorFactory::create();
$request = $serverRequestCreator->createServerRequestFromGlobals();

// Create Error Handler
$responseFactory = $app->getResponseFactory();
$errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);

// Create Shutdown Handler
$shutdownHandler = new ShutdownHandler($request, $errorHandler, true);
register_shutdown_function($shutdownHandler);

$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setDefaultErrorHandler($errorHandler);

// Run App
// $app->run();
// exit();

// Run App & Emit Response
$response = $app->handle($request);
$responseEmitter = new ResponseEmitter();
$responseEmitter->emit($response);
exit();