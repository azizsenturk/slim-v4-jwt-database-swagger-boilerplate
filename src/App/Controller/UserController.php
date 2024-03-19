<?php

declare (strict_types = 1);

namespace App\Controller;

use Core\Base\BaseController;
use OpenApi\Attributes as OA;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Utils\Libs\Validator;

final class UserController extends BaseController {
    protected $repository;

    public function __construct(ContainerInterface $container) {
        $this->repository = $container->get('UserRepository');
        parent::__construct($container);
    }

    #[OA\Get(
        path: '/v1/User/GetAll',
        summary: 'It is used to get all users in the system.',
        tags: ['User'],
        security: [['Bearer' => []]],
        responses: [new OA\Response(response: 200, description: 'Success', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/UserModel')))],
    )]
    public function GetAll(Request $request, Response $response): Response {

        $data = $this->repository->GetAll();
        return $this->withJson($response, $data, 200);

    }

    #[OA\Get(
        path: '/v1/User/GetSingle',
        summary: 'It is used to get the user in the system.',
        tags: ['User'],
        security: [['Bearer' => []]],
        parameters: [new OA\Parameter(name: 'id', in: 'query', description: 'User Id', schema: new OA\Schema(type: 'string'))],
        responses: [new OA\Response(response: 200, description: 'Success', content: new OA\JsonContent(ref: '#/components/schemas/UserModel'))],
    )]
    public function GetSingle(Request $request, Response $response): Response {

        $id = $request->getQueryParams()['id'];
        Validator::Required($id, 'Id is required.');

        $data = $this->repository->GetSingle($id);
        return $this->withJson($response, $data, 200);

    }

    #[OA\Post(
        path: '/v1/User/Create',
        summary: 'It is used to add a new user to the system.',
        tags: ['User'],
        security: [['Bearer' => []]],
        requestBody: new OA\RequestBody(content: new OA\JsonContent(ref: '#/components/schemas/UserModel')),
        responses: [new OA\Response(response: 200, description: 'Success', content: new OA\JsonContent(ref: '#/components/schemas/UserModel'))],
    )]
    public function Create(Request $request, Response $response): Response {

        $payloadData = $request->getParsedBody();
        Validator::Required($payloadData['email'], 'Email is required.');
        Validator::Email($payloadData['email']);

        $data = $this->repository->Create($payloadData);
        return $this->withJson($response, $data, 201);

    }

    #[OA\Put(
        path: '/v1/User/Update',
        summary: 'It is used to update the user in the system.',
        tags: ['User'],
        security: [['Bearer' => []]],
        requestBody: new OA\RequestBody(content: new OA\JsonContent(ref: '#/components/schemas/UserModel')),
        responses: [new OA\Response(response: 200, description: 'Success', content: new OA\JsonContent(ref: '#/components/schemas/UserModel'))],
    )]
    public function Update(Request $request, Response $response): Response {

        $payloadData = $request->getParsedBody();
        Validator::Required($payloadData['id'], 'Id is required.');
        Validator::Required($payloadData['email'], 'Email is required.');
        Validator::Email($payloadData['email']);

        $data = $this->repository->Update($payloadData);
        return $this->withJson($response, $data, 200);

    }

    #[OA\Delete(
        path: '/v1/User/Delete',
        summary: 'It is used to delete the user in the system.',
        tags: ['User'],
        security: [['Bearer' => []]],
        parameters: [new OA\Parameter(name: 'id', in: 'query', description: 'User Id', schema: new OA\Schema(type: 'string'))],
        responses: [new OA\Response(response: 200, description: 'Success')],
    )]
    public function Delete(Request $request, Response $response): Response {

        $id = $request->getQueryParams()['id'];
        Validator::Required($id, 'Id is required.');

        $data = $this->repository->Delete($id);
        return $this->withJson($response, $data, 200);

    }

}
