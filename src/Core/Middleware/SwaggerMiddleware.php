<?php

declare (strict_types = 1);

namespace Core\Middleware;

use OpenApi\Attributes as OA;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

#[OA\Info(title: PROJECT_NAME . " API", version: SWAGGER_VERSION, description: SWAGGER_TEST_BEARER_TOKEN)]
#[OA\Server(url: PROJECT_DOMAIN)]
#[OA\Schemes(format: "http")]
#[OA\SecurityScheme(securityScheme: "Bearer", type: "http", scheme: "bearer", bearerFormat: "JWT", in: "header")]

final class SwaggerMiddleware {
    #[OA\Post(
        path: '/Swagger',
        summary: 'Swagger Documentation',
        tags: ['@Example'],
        security: [['Bearer' => []]],
        parameters: [
            new OA\Parameter(name: 'param1', in: 'query', required: true, schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'param2', in: 'query', required: true, schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'param3', in: 'query', required: true, schema: new OA\Schema(type: 'file')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                type: 'object',
                properties: [
                    new OA\Property(property: 'param3', type: 'datetime'),
                    new OA\Property(property: 'param4', type: 'boolean'),
                ],
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Obje Model Dönüş',
                content: new OA\JsonContent(ref: '#/components/schemas/SwaggerModel')
            ),
            new OA\Response(
                response: 201,
                description: 'Obje Free Dönüş',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'param1', type: 'string'),
                        new OA\Property(property: 'param2', type: 'integer'),
                        new OA\Property(property: 'param3', type: 'boolean'),
                    ],
                )
            ),
            new OA\Response(
                response: 202,
                description: 'Array Model Dönüş',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: '#/components/schemas/SwaggerModel')
                )
            ),
            new OA\Response(
                response: 203,
                description: 'Array Obje Free Dönüş',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        type: 'object',
                        properties: [
                            new OA\Property(property: 'param1', type: 'float'),
                            new OA\Property(property: 'param2', type: 'datetime'),
                        ]
                    )
                )
            ),
            new OA\Response(
                response: 204,
                description: 'Serbest Örnek Dönüş',
                content: new OA\JsonContent(example: ['param1' => 0, 'param2' => 'string', 'param3' => true])
            ),
            new OA\Response(response: 400, description: 'Hata dönüşü'),
        ],
    )]

    public function __invoke(Request $request, Response $response, $next): Response {

        $openapi = \OpenApi\Generator::scan([APP_ROOT . '/src']);
        $swaggerJson = $openapi->toJson();
        $outputPath = APP_ROOT . '/swagger/swagger.json';
        file_put_contents($outputPath, $swaggerJson);

        $_POST['secret'] = SWAGGER_SECRET_KEY;
        $body = require APP_ROOT . '/swagger/index.php';
        $response->withHeader('Content-Type', 'text/html');

        return $response;

    }

}
