<?php

declare (strict_types = 1);

namespace Utils\Exception;

class NotFound extends HttpException {

    /** @OA\Property(type="string") */
    protected $title = '404 Not Found';

    /** @OA\Property(type="string") */
    protected $description = 'The server can not find the requested resource.';

    /** @OA\Property(type="integer") */
    protected $code = 404;

    /** @OA\Property(type="string") */
    protected $message = 'Not Found.';
}
