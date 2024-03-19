<?php

declare (strict_types = 1);

namespace Utils\Handlers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Utils\Exception\IntervalServer;

class ShutdownHandler {
    private Request $request;
    private HttpErrorHandler $errorHandler;

    public function __construct(Request $request, HttpErrorHandler $errorHandler) {
        $this->request = $request;
        $this->errorHandler = $errorHandler;
    }

    public function __invoke() {
        $error = error_get_last();
        if ($error) {
            $errorFile = $error['file'];
            $errorLine = $error['line'];
            $errorMessage = $error['message'];
            $errorType = $error['type'];
            $message = 'An error while processing your request. Please try again later.';

            switch ($errorType) {
            case E_USER_ERROR:
                $message = "FATAL ERROR: {$errorMessage}. ";
                $message .= " on line {$errorLine} in file {$errorFile}.";
                break;

            case E_USER_WARNING:
                $message = "WARNING: {$errorMessage}";
                break;

            case E_USER_NOTICE:
                $message = "NOTICE: {$errorMessage}";
                break;

            default:
                $message = "ERROR: {$errorMessage}";
                $message .= " on line {$errorLine} in file {$errorFile}.";
                break;
            }

            $statusCode = 500;
            $exception = new IntervalServer($message, $statusCode);
            $response = $this->responseFactory->createResponse($statusCode);
            $response = $response->withHeader('Content-Type', 'application/json');
            $response = $response->withStatus($statusCode);
            $response->getBody()->write(json_encode($message));

            return $response;
        }
    }
}
