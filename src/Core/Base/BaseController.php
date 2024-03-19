<?php

declare (strict_types = 1);

namespace Core\Base;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;

abstract class BaseController {
    protected $pdo;

    public function __construct(ContainerInterface $container) {
        $this->pdo = $container->get('pdo');
    }

    protected function withJson(Response $response, $message = [], $statusCode = 200): Response {
        $response = $response->withHeader('Content-Type', 'application/json');
        $response = $response->withStatus($statusCode);
        $response->getBody()->write(json_encode($message));
        return $response;
    }

}
