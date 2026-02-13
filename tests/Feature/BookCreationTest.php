<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookCreationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_book_is_created_successfully(): void
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->post('/api/v1/books', [
            'title' => 'Test book',
            'author' => 'John',
            'summary' => 'A test book summary',
            'isbn' => '1234567890123',
        ]);

        $this->assertDatabaseHas('books', [
            'title' => 'Test book',
            'author' => 'John',
            'summary' => 'A test book summary',
            'isbn' => '1234567890123',
        ]);

        $response->assertStatus(201);
    }

    public function test_book_requires_valid_info(): void
    {
        $user = \App\Models\User::factory()->create();
        $fakeBookData = [
            'title' => 'Le',
            'author' => 'Jo',
            'summary' => 'Short',
            'isbn' => '123',
        ];

        $response = $this->actingAs($user)->postJson('/api/v1/books', $fakeBookData);

        $this->assertDatabaseMissing('books', $fakeBookData);

        $response->assertStatus(422);
    }

    public function test_book_creation_requires_authentication(): void
    {
        $fakeBookData = [
            'title' => 'Titre',
            'author' => 'John',
            'summary' => 'Valid summary for the book',
            'isbn' => '1234567890123',
        ];
        $response = $this->postJson('/api/v1/books', $fakeBookData);

        $this->assertDatabaseMissing('books', $fakeBookData);
        $response->assertStatus(401);
    }
}
