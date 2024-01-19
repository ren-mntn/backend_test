<?php

namespace App\Services;

use App\Models\Author;

class AuthorService
{
    public function getAuthors()
    {
        return Author::all();
    }

    public function storeRegister(string $authorName)
    {
        return Author::create([
            'author_name' => $authorName,
        ]);
    }

    public function getAuthorDetail(Author $author)
    {
        return $author->load(['books', 'publishers']);
    }

    public function updateAuthor(string $authorName, Author $author)
    {
        $author->author_name = $authorName;
        $author->save();
        return $author;
    }

    public function deleteAuthor(Author $author)
    {
        $author->delete();
    }
}
