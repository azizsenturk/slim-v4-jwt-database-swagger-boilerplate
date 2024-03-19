<?php

declare (strict_types = 1);

namespace Utils\Exception;

class NotAllowed extends HttpException {

    /** @OA\Property(type="string[]") */
    protected $allowedMethods = [];

    /** @OA\Property(type="string") */
    protected $title = '405 Method Not Allowed';

    /** @OA\Property(type="string") */
    protected $description = 'The method specified in the request is not allowed for the resource identified by the request URI.';

    /** @OA\Property(type="integer") */
    protected $code = 405;

    /** @OA\Property(type="string") */
    protected $message = 'Method Not Allowed.';

    /** @OA\Property(type="string[]") */
    public function getAllowedMethods(): array {
        return $this->allowedMethods;
    }

    /** @OA\Property(type="string[]") */
    public function setAllowedMethods(array $methods): NotAllowed {
        $this->allowedMethods = $methods;
        $this->message = 'Method not allowed. Must be one of: ' . implode(', ', $methods);
        return $this;
    }
}
