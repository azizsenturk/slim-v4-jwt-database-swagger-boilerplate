<?php

declare (strict_types = 1);

namespace Utils\Exception;

class Forbidden extends HttpException {

    /** @OA\Property(type="string") */
    protected $title = '403 Forbidden';

    /** @OA\Property(type="string") */
    protected $description = 'Access to the requested resource is forbidden.';

    /** @OA\Property(type="integer") */
    protected $code = 403;

    /** @OA\Property(type="string") */
    protected $message = 'Forbidden.';
}
