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
        path: '/api/v1/books',
        operationId: 'getBooks',
        tags: ['Books'],
        parameters: [new OA\Parameter(ref: '#/components/parameters/AcceptJson')],
        responses: [
            new OA\Response(response: 200, description: 'List of books'),
            new OA\Response(response: 404, description: 'Not found'),
        ]
    )]
    public function index()
    {
        return BookResource::collection(Book::paginate(2));
    }

    #[OA\Post(
        path: '/api/v1/books',
        operationId: 'createBook',
        tags: ['Books'],
        security: [['BearerAuth' => []]],
        parameters: [new OA\Parameter(ref: '#/components/parameters/AcceptJson')],
        requestBody: new OA\RequestBody(ref: '#/components/requestBodies/Book'),
        responses: [
            new OA\Response(response: 201, description: 'Book created successfully'),
            new OA\Response(response: 422, description: 'Validation Error'),
            new OA\Response(response: 401, description: 'Unauthorized'),
            new OA\Response(response: 404, description: 'Not found'),
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
        path: '/api/v1/books/{id}',
        operationId: 'getSingleBook',
        tags: ['Books'],
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/AcceptJson'),
            new OA\Parameter(ref: '#/components/parameters/BookId'),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Book created successfully'),
            new OA\Response(response: 404, description: 'Not found'),
        ]
    )]
    public function show(Book $book)
    {
        return new BookResource(Cache::remember("book:{$book->id}", 60, fn() => Book::find($book->id)));
    }

    #[OA\Put(
        path: '/api/v1/books/{id}',
        operationId: 'updateBook',
        tags: ['Books'],
        security: [['BearerAuth' => []]],
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/AcceptJson'),
            new OA\Parameter(ref: '#/components/parameters/BookId'),
        ],
        requestBody: new OA\RequestBody(ref: '#/components/requestBodies/Book'),
        responses: [
            new OA\Response(response: 200, description: 'Book updated successfully'),
            new OA\Response(response: 422, description: 'Validation Error'),
            new OA\Response(response: 401, description: 'Unauthorized'),
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
        path: '/api/v1/books/{id}',
        operationId: 'deleteBook',
        tags: ['Books'],
        security: [['BearerAuth' => []]],
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/AcceptJson'),
            new OA\Parameter(ref: '#/components/parameters/BookId'),
        ],
        responses: [
            new OA\Response(response: 204, description: 'Book deleted successfully'),
            new OA\Response(response: 401, description: 'Unauthorized'),
        ]
    )]
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->noContent();
    }
}
