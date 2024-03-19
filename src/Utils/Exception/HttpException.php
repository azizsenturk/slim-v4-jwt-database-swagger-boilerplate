<?php

declare (strict_types = 1);

namespace Utils\Exception;

use Psr\Http\Message\ServerRequestInterface;
use Throwable;

class HttpException extends \Exception {
    protected $request;
    protected $title = '';
    protected $description = '';

    public function __invoke(ServerRequestInterface $request, string $message = '', int $code = 0, ?Throwable $previous = null) {
        parent::__invoke($message, $code, $previous);
        $this->request = $request;
    }

    public function getRequest(): ServerRequestInterface {
        return $this->request;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function setTitle(string $title): self {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function setDescription(string $description): self {
        $this->description = $description;
        return $this;
    }
}
