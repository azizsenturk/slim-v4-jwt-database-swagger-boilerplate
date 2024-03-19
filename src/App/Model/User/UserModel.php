<?php

namespace App\Model\User;

use Core\Base\BaseModel;
use OpenApi\Attributes as OA;

#[OA\Schema(type: 'object', title: 'UserModel')]
class UserModel extends BaseModel {
    #[OA\Property(type: 'string', description: 'User ID')]
    public ?string $id;

    #[OA\Property(type: 'string', description: 'User name')]
    public ?string $userName;

    #[OA\Property(type: 'string', description: 'E-mail address')]
    public ?string $email;

    #[OA\Property(type: 'enum', description: 'User role', enum: ['admin', 'user'])]
    public ?string $role;

}