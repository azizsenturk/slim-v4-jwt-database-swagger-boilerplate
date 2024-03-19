<?php

declare (strict_types = 1);

namespace App\Model\UploadFile;

use Core\Base\BaseModel;
use OpenApi\Attributes as OA;

#[OA\Schema(type: 'object', title: 'FileModel')]
class FileModel extends BaseModel {
    #[OA\Property(type: 'string', description: 'Image ID')]
    public ?string $id;

    #[OA\Property(type: 'string', description: 'Image type')]
    public ?string $name;

    #[OA\Property(type: 'string', description: 'Image size')]
    public ?float $size;

    #[OA\Property(type: 'string', description: 'Image URL')]
    public ?string $url;

    #[OA\Property(type: 'string', description: 'Image type')]
    public ?string $type;

}