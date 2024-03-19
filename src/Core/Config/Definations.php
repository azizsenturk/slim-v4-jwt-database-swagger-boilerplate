<?php

declare (strict_types = 1);

use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {

    define('PROJECT_NAME', $_ENV['PROJECT_NAME']);
    define('PROJECT_DOMAIN', $_ENV['PROJECT_DOMAIN']);

    define('SWAGGER_VERSION', $_ENV['SWAGGER_VERSION']);
    define('SWAGGER_SECRET_KEY', $_ENV['SWAGGER_SECRET_KEY']);
    define('SWAGGER_TEST_BEARER_TOKEN', $_ENV['SWAGGER_TEST_BEARER_TOKEN']);

    define('DATABASE_HOST', $_ENV['DATABASE_HOST']);
    define('DATABASE_NAME', $_ENV['DATABASE_NAME']);
    define('DATABASE_USER', $_ENV['DATABASE_USER']);
    define('DATABASE_PASS', $_ENV['DATABASE_PASS']);
    define('DATABASE_PREFIX', $_ENV['DATABASE_PREFIX']);

    define('JWT_SECRET_KEY', $_ENV['JWT_SECRET_KEY']);
    define('JWT_ISSUER', $_ENV['JWT_ISSUER']);
    define('JWT_AUDIENCE', $_ENV['JWT_AUDIENCE']);
    define('JWT_EXPIRE_DAY', $_ENV['JWT_EXPIRE_DAY']);

    define('IMAGE_RESIZE_LONG_SIDE', $_ENV['IMAGE_RESIZE_LONG_SIDE']);
    define('IMAGE_CROP_SIZE', $_ENV['IMAGE_CROP_SIZE']);

    define('SHOW_ERROR_REPORTING', $_ENV['SHOW_ERROR_REPORTING']);

};