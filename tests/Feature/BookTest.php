<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Book;
use App\Models\Author;
use App\Models\Publisher;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Http\Controllers\BookController::index
     */
    public function test_list_books()
    {
        Book::factory()->count(3)->create();

        $response = $this->get('/api/books');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'isbn',
                'name',
                'publishedAt',
                'author' => [
                    'authorId',
                    'name',
                ],
                'publisher' => [
                    'publisherId',
                    'name',
                ],
            ],
        ]);
    }

    /**
     * @covers \App\Http\Controllers\BookController::store
     */
    public function test_create_book()
    {
        $author = Author::factory()->create();
        $publisher = Publisher::factory()->create();
        $data = [
            'isbn' => '123-4567890',
            'book_name' => 'New Book',
            'published_at' => now()->format('Y-m-d\TH:i:s.u'),
            'author_id' => $author->id,
            'publisher_id' => $publisher->id,
        ];

        $response = $this->post('/api/books', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('books', $data);
    }

    /**
     * @covers \App\Http\Controllers\BookController::show
     */
    public function test_show_book()
    {
        $book = Book::factory()->create();

        $response = $this->get("/api/books/{$book->isbn}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'isbn',
            'name',
            'publishedAt',
            'author' => [
                'authorId',
                'name',
            ],
            'publisher' => [
                'publisherId',
                'name',
            ],
        ]);
    }

    /**
     * @covers \App\Http\Controllers\BookController::update
     */
    public function test_update_book()
    {
        $book = Book::factory()->create();
        $data = [
            'book_name' => 'Updated Book',
        ];

        $response = $this->put("/api/books/{$book->isbn}", $data);

        $response->assertStatus(204);
        $this->assertDatabaseHas('books', [
            'isbn' => $book->isbn,
            'book_name' => $data['book_name'],
        ]);
    }

    /**
     * @covers \App\Http\Controllers\BookController::delete
     */
    public function test_delete_book()
    {
        $book = Book::factory()->create();
        $authorId = $book->author_id;
        $publisherId = $book->publisher_id;

        $response = $this->delete("/api/books/{$book->isbn}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('books', ['isbn' => $book->isbn]);
        $this->assertDatabaseHas('authors', ['id' => $authorId]);
        $this->assertDatabaseHas('publishers', ['id' => $publisherId]);
    }
}
