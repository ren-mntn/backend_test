<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Services\BookService;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * @return BookResource
     */
    public function index()
    {
        $books = $this->bookService->getBooks();
        return BookResource::collection($books);
    }

    /**
     * @param  \App\Http\Requests\StoreBookRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookRequest $request)
    {
        $this->bookService->storeRegister($request);
        return response(null, 201);
    }

    /**
     * @param  \App\Models\Book  $book
     * @return BookResource
     */
    public function show(Book $book)
    {
        $bookDetail = $this->bookService->getBookDetail($book);
        return  new BookResource($bookDetail);
    }

    /**
     * @param  \App\Http\Requests\UpdateBookRequest  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $this->bookService->updateBook($request, $book);
        return response(null, 204);
    }

    /**
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $this->bookService->deleteBook($book);
        return response(null, 204);
    }
}
