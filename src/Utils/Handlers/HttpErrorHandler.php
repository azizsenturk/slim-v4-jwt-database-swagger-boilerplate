<?php

declare (strict_types = 1);

namespace Utils\Handlers;

use Psr\Http\Message\ResponseInterface as Response;
use Slim\Handlers\ErrorHandler as SlimErrorHandler;

class HttpErrorHandler extends SlimErrorHandler {
    protected function respond(): Response {
        $exception = $this->exception;

        $statusCode = $this->getInformation($exception, 'getCode');
        $statusCode = is_numeric($statusCode) && $statusCode > 0 ? (int) $statusCode : 500;

        $message = [
            'title' => $this->getInformation($exception, 'getTitle') ?? 'Internal Server Error',
            'description' => $this->getInformation($exception, 'getDescription') ?? 'Something went wrong.',
            'message' => $this->getInformation($exception, 'getMessage') ?? 'Internal Server Error',
            'code' => $statusCode,
        ];

        $response = $this->responseFactory->createResponse($statusCode);
        $response = $response->withHeader('Content-Type', 'application/json');
        $response = $response->withStatus($statusCode);
        $response->getBody()->write(json_encode($message));

        return $response;
    }

    private function getInformation($exception, $functionName) {
        $text = null;

        if (method_exists($exception, $functionName)) {
            $text = $exception->$functionName();
        }

        return $text;
    }
}
