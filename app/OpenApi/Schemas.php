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
    new OA\Property(property: '_links', type: 'object', properties: [
      new OA\Property(property: 'self', type: 'string', example: 'http://localhost:8000/api/v1/books/1'),
      new OA\Property(property: 'update', type: 'string', example: 'http://localhost:8000/api/v1/books/1'),
      new OA\Property(property: 'delete', type: 'string', example: 'http://localhost:8000/api/v1/books/1'),
    ]),
  ]
)]
#[OA\Schema(
  schema: 'BookListWithPagination',
  type: 'object',
  properties: [
    new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/BookResponse')),
    new OA\Property(
      property: 'links',
      type: 'object',
      properties: [
        new OA\Property(property: 'first', type: 'string', example: 'http://localhost:8000/api/v1/books?page=1'),
        new OA\Property(property: 'last', type: 'string', example: 'http://localhost:8000/api/v1/books?page=10'),
        new OA\Property(property: 'prev', type: 'string', example: 'http://localhost:8000/api/v1/books?page=1'),
        new OA\Property(property: 'next', type: 'string', example: 'http://localhost:8000/api/v1/books?page=3'),
      ]
    ),
    new OA\Property(property: 'meta', type: 'object', properties: [
      new OA\Property(property: 'current_page', type: 'integer', example: 2),
      new OA\Property(property: 'from', type: 'integer', example: 11),
      new OA\Property(property: 'last_page', type: 'integer', example: 10),
      new OA\Property(property: 'path', type: 'string', example: 'http://localhost:8000/api/v1/books'),
      new OA\Property(property: 'per_page', type: 'integer', example: 10),
      new OA\Property(property: 'to', type: 'integer', example: 20),
      new OA\Property(property: 'total', type: 'integer', example: 100),
      new OA\Property(property: 'links', type: 'array', items: new OA\Items(
        type: 'object',
        properties: [
          new OA\Property(property: 'url', type: 'string', example: 'http://localhost:8000/api/v1/books?page=1'),
          new OA\Property(property: 'label', type: 'string', example: '&laquo; Previous'),
          new OA\Property(property: 'active', type: 'boolean', example: false),
          new OA\Property(property: 'page', type: 'integer', example: 3),
        ]
      )),
    ])
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
  schema: 'UnauthenticatedMessage',
  type: 'object',
  properties: [
    new OA\Property(property: 'message', type: 'string', example: 'Unauthenticated'),
  ]
)]
#[OA\Schema(
  schema: 'NoContentMessage',
  type: 'object',
  properties: [
    new OA\Property(property: 'message', type: 'string', example: 'No content'),
  ]
)]
#[OA\Schema(
  schema: 'InvalidCredentialsMessage',
  type: 'object',
  properties: [
    new OA\Property(property: 'message', type: 'string', example: 'Invalid credentials'),
  ]
)]
#[OA\Schema(
  schema: 'AlreadyExistsMessage',
  type: 'object',
  properties: [
    new OA\Property(property: 'message', type: 'string', example: 'The email has already been taken'),
    new OA\Property(property: 'errors', type: 'object', properties: [
      new OA\Property(property: 'email', type: 'array', items: new OA\Items(type: 'string', example: 'The email has already been taken')),
    ]),
  ]
)]
#[OA\Schema(
  schema: 'ValidationErrorMessage',
  type: 'object',
  properties: [
    new OA\Property(property: 'message', type: 'string', example: 'Validation error'),
    new OA\Property(property: 'errors', type: 'object', properties: [
      new OA\Property(property: 'field_name', type: 'array', items: new OA\Items(type: 'string', example: 'Error message for the field')),
    ]),
  ]
)]
#[OA\Schema(
  schema: 'LogoutSuccessMessage',
  type: 'object',
  properties: [
    new OA\Property(property: 'message', type: 'string', example: 'User logged out successfully'),
  ]
)]
#[OA\Schema(
  schema: 'NotFoundMessage',
  type: 'object',
  properties: [
    new OA\Property(property: 'message', type: 'string', example: 'Not found'),
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
    new OA\Property(property: 'email_verified_at', type: 'string', format: 'date-time', example: '2024-01-01T00:00:00Z'),
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
    new OA\Property(property: 'access_token', type: 'string', example: '{token}'),
  ]
)]
class Schemas
{
  // This class exists only to hold OpenAPI schema definitions
}
