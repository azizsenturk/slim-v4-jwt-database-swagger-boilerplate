<?php

namespace App\Model\Auth;

use Core\Base\BaseModel;
use OpenApi\Attributes as OA;

#[OA\Schema(type: 'object', title: 'RegisterModel')]
class RegisterModel extends BaseModel {

    #[OA\Property(type: 'string', description: 'E-mail address')]
    public ?string $email;

    #[OA\Property(type: 'string', description: 'Password')]
    public ?string $password;

    #[OA\Property(type: 'string', description: 'Password confirmation')]
    public ?string $passwordConfirm;

}