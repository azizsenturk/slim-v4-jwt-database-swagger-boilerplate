<?php

declare (strict_types = 1);

use App\Controller\AuthController;
use App\Controller\UploadFileController;
use App\Controller\UserController;
use Core\Middleware\JwtAuth;
use Core\Middleware\SwaggerMiddleware;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->group('/v1', function (Group $v1) {

        $v1->get('/swagger', SwaggerMiddleware::class);

        $v1->group('/Auth', function (Group $auth) {

            $auth->post('/Login', [AuthController::class, 'Login']);
            $auth->post('/Register', [AuthController::class, 'Register']);
            $auth->get('/AutoLogin', [AuthController::class, 'AutoLogin'])->add(new JwtAuth());
            $auth->get('/Logout', [AuthController::class, 'Logout'])->add(new JwtAuth());

        });

        $v1->group('/User', function (Group $user) {

            $user->get('/GetAll', [UserController::class, 'GetAll']);
            $user->get('/GetSingle', [UserController::class, 'GetSingle']);
            $user->post('/Create', [UserController::class, 'Create']);
            $user->put('/Update', [UserController::class, 'Update']);
            $user->delete('/Delete', [UserController::class, 'Delete']);

        })->add(new JwtAuth());

        $v1->group('/UploadFile', function (Group $uploadFile) {

            $uploadFile->post('/CreateFile', [UploadFileController::class, 'CreateFile']);

        })->add(new JwtAuth());

    });
};
