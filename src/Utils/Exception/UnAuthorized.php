<?php

declare (strict_types = 1);

namespace Utils\Exception;

class UnAuthorized extends HttpException {

    /** @OA\Property(type="string") */
    protected $title = '401 Unauthorized';

    /** @OA\Property(type="string") */
    protected $description = 'Authentication is required and has failed or has not been provided.';

    /** @OA\Property(type="integer") */
    protected $code = 401;

    /** @OA\Property(type="string") */
    protected $message = 'Unauthorized.';
}
