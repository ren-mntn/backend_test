<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use App\Http\Requests\PublisherRequest;
use App\Http\Resources\PublisherResource;

class PublisherController extends Controller
{
    /**
     * @return PublisherResource
     */
    public function index()
    {
        return PublisherResource::collection(Publisher::all());
    }

    /**
     * @param  \App\Http\Requests\PublisherRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PublisherRequest $request)
    {
        $publisherData = $request->validated();
        $publisher = Publisher::createPublisher($publisherData);
        return response($publisher, 201);
    }

    /**
     * @param  \App\Models\Publisher  $publisher
     * @return PublisherResource
     */
    public function show(Publisher $publisher)
    {
        $publisherDetail = $publisher->load(['books', 'authors']);
        return  new PublisherResource($publisherDetail);
    }


    /**
     * @param  \App\Http\Requests\PublisherRequest  $request
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function update(PublisherRequest $request, Publisher $publisher)
    {
        $publisherData = $request->validated();
        $updatedPublisher = $publisher->updatePublisher($publisherData);
        return response($updatedPublisher, 200);
    }

    /**
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Publisher $publisher)
    {
        $publisher->delete();
        return response(null, 204);
    }
}
