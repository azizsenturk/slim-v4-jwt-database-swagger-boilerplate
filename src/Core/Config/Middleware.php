<?php

declare (strict_types = 1);

use Core\Middleware\SessionMiddleware;
use Slim\App;

return function (App $app) {

    $app->addBodyParsingMiddleware();
    $app->add(SessionMiddleware::class);

};
