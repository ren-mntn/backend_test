<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Author;
use App\Models\Book;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Http\Controllers\AuthorController::index
     */
    public function test_list_authors()
    {
        $response = $this->get('/api/authors');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'authorId',
                'name'
            ],
        ]);
    }

    /**
     * @covers \App\Http\Controllers\AuthorController::store
     */
    public function test_create_author()
    {
        $data = ['author_name' => 'New Author'];

        $response = $this->post('/api/authors', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('authors', $data);
    }

    /**
     * @covers \App\Http\Controllers\AuthorController::show
     */
    public function test_show_author()
    {
        $book = Book::factory()->create();

        $response = $this->get("/api/authors/{$book->author_id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'authorId',
            'name',
            'books' => [
                '*' => [
                    'isbn',
                    'name',
                    'publishedAt',
                    'authorId',
                    'publisherId',
                ],
            ],
            'relatedPublishers' => [
                '*' => [
                    'publisherId',
                    'name',
                ],
            ],
        ]);
    }

    /**
     * @covers \App\Http\Controllers\AuthorController::update
     */
    public function test_update_author()
    {
        $author = Author::factory()->create();

        $data = [
            'author_name' => 'Updated Name',
        ];

        $response = $this->put("/api/authors/{$author->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('authors', [
            'id' => $author->id,
            'author_name' => $data['author_name'],
        ]);
    }

    /**
     * @covers \App\Http\Controllers\AuthorController::delete
     */
    public function test_delete_author()
    {
        $author = Author::factory()->has(Book::factory()->count(3))->create();

        $response = $this->delete("/api/authors/{$author->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('authors', [
            'id' => $author->id,
        ]);

        foreach ($author->books as $book) {
            $this->assertDatabaseMissing('books', [
                'id' => $book->id,
            ]);
        }
    }
}
