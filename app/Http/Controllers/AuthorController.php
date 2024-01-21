<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Http\Resources\AuthorResource;

class AuthorController extends Controller
{
    /**
     * @return AuthorResource
     */
    public function index()
    {
        return AuthorResource::collection(Author::all());
    }

    /**
     * @param  \App\Http\Requests\StoreAuthorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAuthorRequest $request)
    {
        $authorData = $request->validated();
        $author = Author::createAuthor($authorData);
        return response($author, 201);
    }

    /**
     * @param  \App\Models\Author  $author
     * @return AuthorResource
     */
    public function show(Author $author)
    {
        $authorDetail = $author->load(['books', 'publishers']);
        return  new AuthorResource($authorDetail);
    }

    /**
     * @param  \App\Http\Requests\UpdateAuthorRequest  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAuthorRequest $request, Author $author)
    {
        $authorData = $request->validated();
        $updatedAuthor = $author->updateAuthor($authorData);
        return response($updatedAuthor, 200);
    }

    /**
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        $author->delete();
        return response(null, 204);
    }
}
