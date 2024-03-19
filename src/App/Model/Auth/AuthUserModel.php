<?php

namespace App\Model\Auth;

use Core\Base\BaseModel;
use OpenApi\Attributes as OA;

#[OA\Schema(type: 'object', title: 'AuthUserModel')]
class AuthUserModel extends BaseModel {

    #[OA\Property(type: 'string', description: 'JWT Token')]
    public ?string $token;

    #[OA\Property(type: 'string', description: 'User name')]
    public ?string $userName;

    #[OA\Property(type: 'string', description: 'E-mail address')]
    public ?string $email;

    #[OA\Property(type: 'enum', description: 'User role', enum: ['admin', 'user'])]
    public ?string $role;

}