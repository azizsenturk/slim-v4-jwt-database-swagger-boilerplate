<?php

declare (strict_types = 1);

namespace App\Model;

use Core\Base\BaseModel;
use OpenApi\Attributes as OA;

#[OA\Schema(type: 'object', title: 'FreeModel')]
final class FreeModel extends BaseModel {
}