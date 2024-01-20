<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;

class BookController extends Controller
{
    /**
     * @return BookResource
     */
    public function index()
    {
        return BookResource::collection(Book::all());
    }

    /**
     * @param  \App\Http\Requests\StoreBookRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookRequest $request)
    {
        $bookData = $request->validated();
        $book = Book::createBook($bookData);
        return response($book, 201);
    }

    /**
     * @param  \App\Models\Book  $book
     * @return BookResource
     */
    public function show(Book $book)
    {
        $bookDetail = $book->load(['author', 'publisher']);
        return  new BookResource($bookDetail);
    }

    /**
     * @param  \App\Http\Requests\UpdateBookRequest  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $updatedData = $request->validated();
        $updatedBook = $book->updateBook($updatedData);
        return response($updatedBook, 200);
    }

    /**
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return response(null, 204);
    }
}
