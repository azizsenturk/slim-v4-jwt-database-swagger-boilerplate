<?php

namespace App\Model\Auth;

use Core\Base\BaseModel;
use OpenApi\Attributes as OA;

#[OA\Schema(type: 'object', title: 'LoginModel')]
class LoginModel extends BaseModel {

    #[OA\Property(type: 'string', description: 'E-mail address')]
    public ?string $email;

    #[OA\Property(type: 'string', description: 'Password')]
    public ?string $password;

}