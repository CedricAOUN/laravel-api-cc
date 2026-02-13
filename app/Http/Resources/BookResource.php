<?php

namespace App\Http\Resources;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Book
 */
class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'author' => strtoupper($this->author),
            'summary' => $this->summary,
            'isbn' => $this->isbn,
            '_links' => [
                'self' => route('books.show', ['book' => $this->id]),
                'update' => route('books.update', ['book' => $this->id]),
                'delete' => route('books.destroy', ['book' => $this->id]),
                'all' => route('books.index'),
            ],
        ];
    }
}
