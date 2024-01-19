<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use App\Services\PublisherService;
use App\Http\Requests\StorePublisherRequest;
use App\Http\Requests\UpdatePublisherRequest;
use App\Http\Resources\PublisherResource;

class PublisherController extends Controller
{
    protected $publisherService;

    public function __construct(PublisherService $publisherService)
    {
        $this->publisherService = $publisherService;
    }

    /**
     * @return PublisherResource
     */
    public function index()
    {
        $publishers = $this->publisherService->getPublishers();
        return PublisherResource::collection($publishers);
    }

    /**
     * @param  \App\Http\Requests\StorePublisherRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePublisherRequest $request)
    {
        $this->publisherService->storeRegister($request->name);
        return response(null, 201);
    }

    /**
     * @param  \App\Models\Publisher  $publisher
     * @return PublisherResource
     */
    public function show(Publisher $publisher)
    {
        $publisherDetail = $this->publisherService->getPublisherDetail($publisher);
        return  new PublisherResource($publisherDetail);
    }


    /**
     * @param  \App\Http\Requests\UpdatePublisherRequest  $request
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePublisherRequest $request, Publisher $publisher)
    {
        $this->publisherService->updatePublisher($request->name, $publisher);
        return response(null, 204);
    }

    /**
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Publisher $publisher)
    {
        $this->publisherService->deletePublisher($publisher);
        return response(null, 204);
    }
}
