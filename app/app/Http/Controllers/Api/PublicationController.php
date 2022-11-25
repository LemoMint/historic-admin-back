<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PublicationService;
use App\Http\Resources\PublicationResource;
use App\Http\Requests\Publication\PublicationCreateDto;
use App\Http\Requests\Publication\PublicationUpdateDto;
use App\Http\Requests\Publication\PublicationSortRequest;

class PublicationController extends Controller
{
    public function __construct(private PublicationService $publicationService) {}

    public function index(PublicationSortRequest $request)
    {
        return response()->json(
            PublicationResource::collection(
                $this->publicationService->getAll($request)
            )
        );
    }

    public function store(PublicationCreateDto $dto)
    {
        return response()->json(
            new PublicationResource($this->publicationService->store($dto))
        );
    }

    public function show($id)
    {
        return response()->json(
            new PublicationResource(
                $this->publicationService->find($id)
            )
        );
    }

    public function update(PublicationUpdateDto $dto, $id)
    {
        $publication = $this->publicationService->find($id);

        // $this->authorize('update', $publication);

        return response()->json(
            new PublicationResource($this->publicationService->update($dto, $publication))
        );
    }

    public function destroy($id)
    {
        $publication = $this->publicationService->find($id);

        // $this->authorize('delete', $publication);

        $this->publicationService->delete($publication);
    }
}
