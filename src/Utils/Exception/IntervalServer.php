<?php

declare (strict_types = 1);

namespace Utils\Exception;

class IntervalServer extends HttpException {

    /** @OA\Property(type="string") */
    protected $title = '500 Internal Server Error';

    /** @OA\Property(type="string") */
    protected $description = 'The server encountered an unexpected condition that prevented it from fulfilling the request.';

    /** @OA\Property(type="integer") */
    protected $code = 500;

    /** @OA\Property(type="string") */
    protected $message = 'Internal Server Error.';
}
