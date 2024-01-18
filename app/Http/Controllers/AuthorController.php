<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Services\AuthorService;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Http\Resources\AuthorResource;

class AuthorController extends Controller
{

    protected $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    /**
     * @return ItemShowResource
     */
    public function index()
    {
        $authors = $this->authorService->getAuthors();
        return AuthorResource::collection($authors);
    }

    /**
     * @param  \App\Http\Requests\StoreAuthorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAuthorRequest $request)
    {
        $this->authorService->storeRegister($request->name);
        return response(null, 201);
    }

    /**
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\ItemShowResource
     */
    public function show(Author $author)
    {
        $authorDetail = $this->authorService->getAuthorDetail($author);
        return  new AuthorResource($authorDetail);
    }

    /**
     * @param  \App\Http\Requests\UpdateAuthorRequest  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAuthorRequest $request, Author $author)
    {
        $this->authorService->updateAuthor($request->name, $author);
        return response(null, 204);
    }

    /**
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        $this->authorService->deleteAuthor($author);
        return response(null, 204);
    }
}
