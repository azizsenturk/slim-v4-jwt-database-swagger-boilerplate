<?php

declare (strict_types = 1);

use App\Repository\AuthRepository;
use App\Repository\UploadFileRepository;
use App\Repository\UserRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {

    $containerBuilder->addDefinitions([
        'AuthRepository' => \DI\autowire(AuthRepository::class),
        'UserRepository' => \DI\autowire(UserRepository::class),
        'UploadFileRepository' => \DI\autowire(UploadFileRepository::class),
    ]);

};
