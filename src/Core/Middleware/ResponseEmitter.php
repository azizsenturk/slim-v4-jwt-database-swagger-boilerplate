<?php

declare (strict_types = 1);

namespace Core\Middleware;

use Core\Config\AllowedOrigins;
use Psr\Http\Message\ResponseInterface;
use Slim\ResponseEmitter as SlimResponseEmitter;

class ResponseEmitter extends SlimResponseEmitter {

    public function emit(ResponseInterface $response): void {
        $allowedOrigins = AllowedOrigins::getOrigins();

        $origin = $_SERVER['HTTP_ORIGIN'] ?? null;

        if ($origin && !in_array($origin, $allowedOrigins)) {
            header('Content-Type: application/json');
            http_response_code(403);
            $forbiddenData = array("title" => '403 Forbidden', "description" => 'Access to the requested resource is forbidden.', "code" => 403, "message" => 'Forbidden.');
            echo json_encode($forbiddenData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            exit;
        }

        if (in_array($origin, $allowedOrigins)) {
            $response = $response->withHeader('Access-Control-Allow-Origin', $origin);
        }

        $response = $response
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization', )
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS')
            ->withHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->withAddedHeader('Cache-Control', 'post-check=0, pre-check=0')
            ->withHeader('Pragma', 'no-cache');

        parent::emit($response);
    }

}
