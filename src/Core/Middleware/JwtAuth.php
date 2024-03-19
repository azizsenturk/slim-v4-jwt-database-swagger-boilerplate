<?php

declare (strict_types = 1);

namespace Core\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Utils\Exception\UnAuthorized;
use Utils\Service\JWTService;

final class JwtAuth {

    public function __invoke(Request $request, RequestHandler $handler): Response {

        // Middleware'den önceki işlemleri burada yapabilirsiniz

        $jwtHeader = $request->getHeaderLine('Authorization');
        if (!$jwtHeader) {
            throw new UnAuthorized('JWT Token not found in request header.');
        }

        $jwtToken = end(explode('Bearer ', $jwtHeader));
        if (!isset($jwtToken)) {
            throw new UnAuthorized('JWT Token not found in request header.');
        }

        try {
            JWTService::DecodeToken($jwtToken);
        } catch (\Exception $e) {
            throw new UnAuthorized('JWT Token is not valid.');
        }

        $response = $handler->handle($request);

        // Middleware'den sonraki işlemleri burada yapabilirsiniz

        return $response;
    }

}