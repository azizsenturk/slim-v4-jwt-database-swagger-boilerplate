<?php

namespace App\Model;

use OpenApi\Attributes as OA;

#[OA\Schema(type: 'object', title: 'SwaggerModel')]
class SwaggerModel {

    #[OA\Property(type: 'string')]
    public ?string $stringParam;

    #[OA\Property(type: 'integer')]
    public ?int $integerParam;

    #[OA\Property(type: 'boolean')]
    public ?bool $booleanParam;

    #[OA\Property(type: 'float')]
    public ?float $floatParam;

    #[OA\Property(type: 'datetime')]
    public ?string $datetimeParam;

    #[OA\Property(type: 'enum', enum: ['enum1', 'enum2', 'enum3'])]
    public ?string $enumParam;

    #[OA\Property(type: 'string', nullable: true)]
    public ?string $nullableStringParam;

    #[OA\Property(type: 'object')]
    public ?array $objectParam;

    #[OA\Property(type: 'array', items: new OA\Items(type: 'string'))]
    public ?array $arrayParam;

    #[OA\Property(type: 'object', properties: [new OA\Property(property: 'property1', type: 'string'), new OA\Property(property: 'property2', type: 'integer')])]
    public ?object $objectFreeParam;

    #[OA\Property(type: 'array', items: new OA\Items(type: 'object', properties: [new OA\Property(property: 'property1', type: 'string'), new OA\Property(property: 'property2', type: 'integer')]))]
    public ?array $arrayObjectFreeParam;

    #[OA\Property(type: 'object', ref: '#/components/schemas/SwaggerModel')]
    public ?object $objectRefParam;

    #[OA\Property(type: 'array', items: new OA\Items(ref: '#/components/schemas/SwaggerModel'))]
    public ?array $arrayObjectRefParam;

}
