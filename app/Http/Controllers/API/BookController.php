<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

use OpenApi\Attributes as OA;

class BookController extends Controller
{
    #[OA\Get(
        path: '/books',
        operationId: 'getBooks',
        tags: ['Books'],
        parameters: [new OA\Parameter(ref: '#/components/parameters/AcceptJson')],
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of books',
                content: new OA\JsonContent(ref: '#/components/schemas/BookListWithPagination')
            ),
            new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/GenericMessage')),
        ]
    )]
    public function index()
    {
        return BookResource::collection(Book::paginate(2));
    }

    #[OA\Post(
        path: '/books',
        operationId: 'createBook',
        tags: ['Books'],
        security: [['BearerAuth' => []]],
        parameters: [new OA\Parameter(ref: '#/components/parameters/AcceptJson'), new OA\Parameter(ref: '#/components/parameters/AuthToken')],
        requestBody: new OA\RequestBody(ref: '#/components/requestBodies/Book'),
        responses: [
            new OA\Response(response: 201, description: 'Book created successfully', content: new OA\JsonContent(ref: '#/components/schemas/BookResponse')),
            new OA\Response(response: 422, description: 'Validation Error', content: new OA\JsonContent(ref: '#/components/schemas/GenericMessage')),
            new OA\Response(response: 401, description: 'Unauthorized', content: new OA\JsonContent(ref: '#/components/schemas/GenericMessage')),
            new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/GenericMessage')),
        ]
    )]
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'author' => 'required|string|min:3|max:100',
            'summary' => 'required|string|min:10|max:500',
            'isbn' => 'required|string|size:13|unique:books,isbn',
        ]);
        return new BookResource(Book::create($validated));
    }

    #[OA\Get(
        path: '/books/{id}',
        operationId: 'getSingleBook',
        tags: ['Books'],
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/AcceptJson'),
            new OA\Parameter(ref: '#/components/parameters/BookId'),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Book created successfully', content: new OA\JsonContent(ref: '#/components/schemas/BookResponse')),
            new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/GenericMessage')),
        ]
    )]
    public function show(Book $book)
    {
        return new BookResource(Cache::remember("book:{$book->id}", 60, fn() => Book::find($book->id)));
    }

    #[OA\Put(
        path: '/books/{id}',
        operationId: 'updateBook',
        tags: ['Books'],
        security: [['BearerAuth' => []]],
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/AcceptJson'),
            new OA\Parameter(ref: '#/components/parameters/BookId'),
            new OA\Parameter(ref: '#/components/parameters/AuthToken'),
        ],
        requestBody: new OA\RequestBody(ref: '#/components/requestBodies/Book'),
        responses: [
            new OA\Response(response: 200, description: 'Book updated successfully', content: new OA\JsonContent(ref: '#/components/schemas/BookResponse')),
            new OA\Response(response: 422, description: 'Validation Error', content: new OA\JsonContent(ref: '#/components/schemas/GenericMessage')),
            new OA\Response(response: 401, description: 'Unauthorized', content: new OA\JsonContent(ref: '#/components/schemas/GenericMessage')),
        ]
    )]
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'author' => 'required|string|min:3|max:100',
            'summary' => 'required|string|min:10|max:500',
            'isbn' => 'required|string|size:13|unique:books,isbn,' . $book->id,
        ]);
        $book->update($validated);
        return new BookResource($book);
    }

    #[OA\Delete(
        path: '/books/{id}',
        operationId: 'deleteBook',
        tags: ['Books'],
        security: [['BearerAuth' => []]],
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/AcceptJson'),
            new OA\Parameter(ref: '#/components/parameters/BookId'),
            new OA\Parameter(ref: '#/components/parameters/AuthToken'),
        ],
        responses: [
            new OA\Response(response: 204, description: 'Book deleted successfully'),
            new OA\Response(response: 401, description: 'Unauthorized', content: new OA\JsonContent(ref: '#/components/schemas/GenericMessage')),
        ]
    )]
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->noContent();
    }
}
