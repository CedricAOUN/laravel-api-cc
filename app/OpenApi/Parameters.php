<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Parameter(
    parameter: 'AcceptJson',
    name: 'Accept',
    in: 'header',
    required: true,
    schema: new OA\Schema(type: 'string', default: 'application/json')
)]
#[OA\Parameter(
    parameter: 'AuthToken',
    name: 'Authorization',
    in: 'header',
    required: true,
    description: 'Bearer token for authentication',
    schema: new OA\Schema(type: 'string', example: 'Bearer {token}')
)]
#[OA\Parameter(
    parameter: 'BookId',
    name: 'id',
    in: 'path',
    required: true,
    description: 'Book ID',
    schema: new OA\Schema(type: 'integer')
)]
class Parameters
{
    // This class exists only to hold OpenAPI parameter definitions
}
