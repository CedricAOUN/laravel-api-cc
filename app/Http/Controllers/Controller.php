<?php

namespace App\Http\Controllers;

use OpenApi\Annotations\JsonContent;
use OpenApi\Attributes as OA;

#[OA\Info(title: 'My First API', version: '0.1')]
#[OA\Parameter(
    parameter: 'AcceptJson',
    name: 'Accept',
    in: 'header',
    required: true,
    schema: new OA\Schema(type: 'string', default: 'application/json')
)]
#[OA\SecurityScheme(
    securityScheme: 'BearerAuth',
    type: 'http',
    scheme: 'bearer',
    bearerFormat: 'JWT'
)]
#[OA\Parameter(
    parameter: 'BookId',
    name: 'id',
    in: 'path',
    required: true,
    description: 'Book ID',
    schema: new OA\Schema(type: 'integer')
)]
#[OA\RequestBody(
    request: 'Book',
    required: true,
    content: new OA\JsonContent(
        properties: [
            new OA\Property(property: 'title', type: 'string', example: 'Test book'),
            new OA\Property(property: 'author', type: 'string', example: 'Test author'),
            new OA\Property(property: 'summary', type: 'string', example: 'Test summary of the book'),
            new OA\Property(property: 'isbn', type: 'string', example: '1234567890123'),
        ]
    )
)]
#[OA\RequestBody(
    request: 'UserRegistration',
    required: true,
    content: new OA\JsonContent(
        properties: [
            new OA\Property(property: 'name', type: 'string', example: 'Test name'),
            new OA\Property(property: 'email', type: 'string', example: 'test2@example.com'),
            new OA\Property(property: 'password', type: 'string', example: 'password'),
        ]
    )
)]
#[OA\RequestBody(
    request: 'UserLogin',
    required: true,
    content: new OA\JsonContent(
        properties: [
            new OA\Property(property: 'email', type: 'string', example: 'test2@example.com'),
            new OA\Property(property: 'password', type: 'string', example: 'password'),
        ]
    )
)]
abstract class Controller
{
    //
}
