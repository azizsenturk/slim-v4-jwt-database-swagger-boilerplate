<?php

declare (strict_types = 1);

namespace App\Controller;

use Core\Base\BaseController;
use OpenApi\Attributes as OA;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Utils\Libs\Validator;

final class AuthController extends BaseController {
    protected $repository;

    public function __construct(ContainerInterface $container) {
        $this->repository = $container->get('AuthRepository');
        parent::__construct($container);
    }

    #[OA\Post(
        path: '/v1/Auth/Login',
        summary: 'It is used to log in to the system.',
        tags: ['Auth'],
        security: [],
        requestBody: new OA\RequestBody(content: new OA\JsonContent(ref: '#/components/schemas/LoginModel')),
        responses: [new OA\Response(response: 200, description: 'Success', content: new OA\JsonContent(ref: '#/components/schemas/AuthUserModel'))],
    )]
    public function Login(Request $request, Response $response): Response {

        $payloadData = $request->getParsedBody();
        Validator::Required($payloadData['email'], 'Email is required.');
        Validator::Required($payloadData['password'], 'Password is required.');
        Validator::Email($payloadData['email']);

        $data = $this->repository->Login($payloadData);
        return $this->withJson($response, $data, 200);

    }

    #[OA\Post(
        path: '/v1/Auth/Register',
        summary: 'It is used to register to the system.',
        tags: ['Auth'],
        security: [],
        requestBody: new OA\RequestBody(content: new OA\JsonContent(ref: '#/components/schemas/RegisterModel')),
        responses: [new OA\Response(response: 200, description: 'Success', content: new OA\JsonContent(ref: '#/components/schemas/AuthUserModel'))],
    )]
    public function Register(Request $request, Response $response): Response {

        $payloadData = $request->getParsedBody();
        Validator::Required($payloadData['email'], 'Email is required.');
        Validator::Required($payloadData['password'], 'Password is required.');
        Validator::Required($payloadData['passwordConfirm'], 'Password Confirm is required.');
        Validator::Email($payloadData['email']);

        $data = $this->repository->Register($payloadData);
        return $this->withJson($response, $data, 200);

    }

    #[OA\Get(
        path: '/v1/Auth/AutoLogin',
        summary: 'It is used to automatically log in to systems.',
        tags: ['Auth'],
        security: [['Bearer' => []]],
        responses: [new OA\Response(response: 200, description: 'Success', content: new OA\JsonContent(ref: '#/components/schemas/AuthUserModel'))],
    )]
    public function AutoLogin(Request $request, Response $response, array $args): Response {

        $jwtHeader = $request->getHeaderLine('Authorization');
        Validator::Required($jwtHeader, 'JWT Token not found in request header.');

        $data = $this->repository->AutoLogin($jwtHeader);
        return $this->withJson($response, $data, 200);

    }

}
