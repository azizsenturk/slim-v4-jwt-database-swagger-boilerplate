<?php

declare (strict_types = 1);

namespace Utils\Exception;

class BadRequest extends HttpException {

    /** @OA\Property(type="string") */
    protected $title = '400 Bad Request';

    /** @OA\Property(type="string") */
    protected $description = 'The server could not understand the request due to invalid syntax.';

    /** @OA\Property(type="integer") */
    protected $code = 400;

    /** @OA\Property(type="string") */
    protected $message = 'Bad request.';

}
