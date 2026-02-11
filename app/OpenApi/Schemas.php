<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;


#[OA\Schema(
  schema: 'BookResponse',
  type: 'object',
  properties: [
    new OA\Property(property: 'title', type: 'string', example: 'Test book'),
    new OA\Property(property: 'author', type: 'string', example: 'Test author'),
    new OA\Property(property: 'summary', type: 'string', example: 'Test summary of the book'),
    new OA\Property(property: 'isbn', type: 'string', example: '1234567890123'),
    new OA\Property(property: 'links', type: 'object'),
  ]
)]
#[OA\Schema(
  schema: 'BookListWithPagination',
  type: 'object',
  properties: [
    new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/BookResponse')),
    new OA\Property(property: 'links', type: 'object'),
    new OA\Property(property: 'meta', type: 'object'),
  ]
)]
#[OA\Schema(
  schema: 'GenericMessage',
  type: 'object',
  properties: [
    new OA\Property(property: 'message', type: 'string', example: 'Generic response message'),
  ]
)]
#[OA\Schema(
  schema: 'UserResponse',
  type: 'object',
  properties: [
    new OA\Property(property: 'name', type: 'string', example: 'Test name'),
    new OA\Property(property: 'email', type: 'string', example: 'test2@example.com'),
    new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2024-01-01T00:00:00Z'),
    new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2024-01-01T00:00:00Z'),
    new OA\Property(property: 'id', type: 'integer', example: 1),
  ]
)]
#[OA\Schema(
  schema: 'UserRegisterResponse',
  type: 'object',
  properties: [
    new OA\Property(property: 'message', type: 'string', example: 'User registered successfully'),
    new OA\Property(property: 'user', type: 'object', ref: '#/components/schemas/UserResponse'),
  ]
)]
#[OA\Schema(
  schema: 'UserLoginResponse',
  type: 'object',
  properties: [
    new OA\Property(property: 'user', type: 'object', ref: '#/components/schemas/UserResponse'),
    new OA\Property(property: 'token', type: 'string', example: '{token}'),
  ]
)]
class Schemas
{
  // This class exists only to hold OpenAPI schema definitions
}
