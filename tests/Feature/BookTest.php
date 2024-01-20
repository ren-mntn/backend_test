<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Book;
use App\Models\Author;
use App\Models\Publisher;
use Faker\Factory as Faker;

class BookTest extends TestCase
{
    use RefreshDatabase;

    private $book;
    private $author;
    private $publisher;

    protected function setUp(): void
    {
        parent::setUp();
        $this->author = Author::factory()->create();
        $this->publisher = Publisher::factory()->create();
        $this->book = Book::factory()->create([
            'author_id' => $this->author->id,
            'publisher_id' => $this->publisher->id,
        ]);
    }

    private function createBookData($overrides = [])
    {
        $faker = Faker::create();
        return array_merge([
            'isbn' => $faker->isbn13,
            'book_name' => 'New Book',
            'published_at' => now()->format('Y-m-d'),
            'author_id' => $this->author->id,
            'publisher_id' => $this->publisher->id,
        ], $overrides);
    }

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
        $data = $this->createBookData();

        $response = $this->post('/api/books', $data);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'isbn',
            'book_name',
            'published_at',
            'author_id',
            'publisher_id',
        ]);
        $this->assertDatabaseHas('books', $data);
    }

    /**
     * @covers \App\Http\Controllers\BookController::show
     */
    public function test_show_book()
    {
        $response = $this->get("/api/books/{$this->book->isbn}");

        $response->assertStatus(200);
        $response->assertJson([
            'isbn' => $this->book->isbn,
            'name' => $this->book->book_name,
            'publishedAt' => $this->book->published_at->format('Y-m-d'),
            'author' => [
                'authorId' => $this->book->author->id,
                'name' => $this->book->author->author_name,
            ],
            'publisher' => [
                'publisherId' => $this->book->publisher->id,
                'name' => $this->book->publisher->publisher_name,
            ],
        ]);
    }

    /**
     * @covers \App\Http\Controllers\BookController::update
     */
    public function test_update_book()
    {
        $data = $this->createBookData(['isbn' => $this->book->isbn]);

        $response = $this->put("/api/books/{$this->book->isbn}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('books', $data);
    }

    /**
     * @covers \App\Http\Controllers\BookController::delete
     */
    public function test_delete_book()
    {
        $response = $this->delete("/api/books/{$this->book->isbn}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('books', ['isbn' => $this->book->isbn]);
        $this->assertDatabaseHas('authors', ['id' => $this->book->author_id]);
        $this->assertDatabaseHas('publishers', ['id' => $this->book->publisher_id]);
    }
}
