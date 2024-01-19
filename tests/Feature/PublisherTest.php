<?php

namespace Tests\Feature;

use App\Models\Author;
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
        // 出版社を作成し、出版社に対して3の書籍を生成、書籍は新しい著者に関連付け
        Publisher::factory()->count(3)
            ->has(Book::factory()->count(3)->for(Author::factory(), 'author'))
            ->create();

        $response = $this->get('/api/publishers');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
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
            ],
        ]);
    }

    /**
     * @covers \App\Http\Controllers\PublisherController::store
     */
    public function test_create_publisher()
    {
        $data = [
            'name' => 'New Publisher',
        ];

        $response = $this->post('/api/publishers', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('publishers', $data);
    }

    /**
     * @covers \App\Http\Controllers\PublisherController::show
     */
    public function test_show_publisher()
    {
        $publisher = Publisher::factory()->create();
        $response = $this->get("/api/publishers/{$publisher->id}");

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
        $data = [
            'name' => 'Updated Name',
        ];

        $response = $this->put("/api/publishers/{$publisher->id}", $data);

        $response->assertStatus(204);
        $this->assertDatabaseHas('publishers', [
            'id' => $publisher->id,
            'publisher_name' => $data['name'],
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
}
