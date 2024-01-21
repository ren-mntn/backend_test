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

    /**
     * 必須フィールドのテスト
     * @covers \App\Http\Controllers\AuthorController::store
     */
    public function test_create_author_without_name()
    {
        $response = $this->postJson('/api/authors', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['author_name']);
        $response->assertJsonFragment([
            'author_name' => ['著者名は必須です。']
        ]);
    }

    /**
     * 最大文字数制限のテスト
     * @covers \App\Http\Controllers\AuthorController::store
     */
    public function test_create_author_with_long_name()
    {
        $data = ['author_name' => str_repeat('a', 256)];

        $response = $this->postJson('/api/authors', $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['author_name']);
        $response->assertJsonFragment([
            'author_name' => ['著者名は最大255文字までです。']
        ]);
    }

    /**
     * 文字列型のテスト
     * @covers \App\Http\Controllers\AuthorController::store
     */
    public function test_create_author_with_non_string_name()
    {
        $data = ['author_name' => 12345];

        $response = $this->postJson('/api/authors', $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['author_name']);
        $response->assertJsonFragment([
            'author_name' => ['著者名は文字列である必要があります。']
        ]);
    }


    /**
     * HTMLタグのテスト
     * @covers \App\Http\Controllers\AuthorController::store
     */
    public function test_create_author_with_html_tags()
    {
        $data = ['author_name' => '<script>alert("New Author")</script>'];

        $response = $this->postJson('/api/authors', $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['author_name']);
        $response->assertJsonFragment([
            'author_name' => ['HTMLタグは許可されていません。']
        ]);
    }

    /**
     * 存在しないID
     * @covers \App\Http\Controllers\AuthorController::update
     */
    public function test_update_nonexistent_author()
    {
        $nonExistentAuthorId = 9999;
        $data = ['author_name' => 'Updated Name'];

        $response = $this->put("/api/authors/{$nonExistentAuthorId}", $data);

        $response->assertStatus(404);
    }

    /**
     * 存在しないID
     * @covers \App\Http\Controllers\AuthorController::delete
     */
    public function test_delete_nonexistent_author()
    {
        $nonExistentAuthorId = 9999;

        $response = $this->delete("/api/authors/{$nonExistentAuthorId}");

        $response->assertStatus(404);
    }
}
