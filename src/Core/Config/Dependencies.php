<?php

declare (strict_types = 1);

use Core\Base\BaseService;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {

    $containerBuilder->addDefinitions([
        'pdo' => function () {
            $config = [
                'hostname' => DATABASE_HOST,
                'database' => DATABASE_NAME,
                'username' => DATABASE_USER,
                'password' => DATABASE_PASS,
                'driver' => 'mysql',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'prefix' => DATABASE_PREFIX,
                'debug' => false,
            ];

            $pdo = new \Buki\Pdox($config);

            BaseService::setPDO($pdo);

            return $pdo;
        },

    ]);
};