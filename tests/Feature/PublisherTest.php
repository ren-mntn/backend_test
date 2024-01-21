<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Publisher;

class PublisherTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Http\Controllers\PublisherController::index
     */
    public function test_list_publishers()
    {
        Publisher::factory()->count(3)->create();
        $response = $this->get('/api/publishers');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'publisherId',
                'name',
            ],
        ]);
    }

    /**
     * @covers \App\Http\Controllers\PublisherController::store
     */
    public function test_create_publisher()
    {
        $data = ['publisher_name' => 'New Publisher'];

        $response = $this->post('/api/publishers', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('publishers', $data);
    }

    /**
     * @covers \App\Http\Controllers\PublisherController::show
     */
    public function test_show_publisher()
    {
        $book = Book::factory()->create();

        $response = $this->get("/api/publishers/{$book->publisher->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'publisherId',
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
            'relatedAuthors' => [
                '*' => [
                    'authorId',
                    'name',
                ],
            ],
        ]);
    }

    /**
     * @covers \App\Http\Controllers\PublisherController::update
     */
    public function test_update_publisher()
    {
        $publisher = Publisher::factory()->create();

        $data = ['publisher_name' => 'Updated Name',];

        $response = $this->put("/api/publishers/{$publisher->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('publishers', [
            'id' => $publisher->id,
            'publisher_name' => $data['publisher_name'],
        ]);
    }

    /**
     * @covers \App\Http\Controllers\PublisherController::delete
     */
    public function test_delete_publisher()
    {
        $publisher = Publisher::factory()->hasBooks(3)->create();

        $response = $this->delete("/api/publishers/{$publisher->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('publishers', [
            'id' => $publisher->id,
        ]);

        foreach ($publisher->books as $book) {
            $this->assertDatabaseMissing('books', [
                'isbn' => $book->isbn,
            ]);
        }
    }

    /**
     * 必須フィールドのテスト
     * @covers \App\Http\Controllers\PublisherController::store
     */
    public function test_create_publisher_without_name()
    {
        $response = $this->postJson('/api/publishers', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['publisher_name']);
        $response->assertJsonFragment([
            'publisher_name' => ['出版社名は必須です。']
        ]);
    }

    /**
     * 最大文字数制限のテスト
     * @covers \App\Http\Controllers\PublisherController::store
     */
    public function test_create_publisher_with_long_name()
    {
        $data = ['publisher_name' => str_repeat('a', 256)];

        $response = $this->postJson('/api/publishers', $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['publisher_name']);
        $response->assertJsonFragment([
            'publisher_name' => ['出版社名は最大255文字までです。']
        ]);
    }

    /**
     * 文字列型のテスト
     * @covers \App\Http\Controllers\PublisherController::store
     */
    public function test_create_publisher_with_non_string_name()
    {
        $data = ['publisher_name' => 12345];

        $response = $this->postJson('/api/publishers', $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['publisher_name']);
        $response->assertJsonFragment([
            'publisher_name' => ['出版社名は文字列である必要があります。']
        ]);
    }

    /**
     * 存在しないID
     * @covers \App\Http\Controllers\PublisherController::update
     */
    public function test_update_nonexistent_publisher()
    {
        $nonExistentPublisherId = 9999;
        $data = ['publisher_name' => 'Updated Name'];

        $response = $this->put("/api/publishers/{$nonExistentPublisherId}", $data);

        $response->assertStatus(404);
    }

    /**
     * 存在しないID
     * @covers \App\Http\Controllers\PublisherController::delete
     */
    public function test_delete_nonexistent_publisher()
    {
        $nonExistentPublisherId = 9999;

        $response = $this->delete("/api/publishers/{$nonExistentPublisherId}");

        $response->assertStatus(404);
    }
}
