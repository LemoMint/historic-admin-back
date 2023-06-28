<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\SortRequest;
use App\Http\Controllers\Controller;
use App\Services\PublishingHouseService;
use App\Http\Resources\PublishingHouseResource;
use App\Http\Requests\PublishingHouse\PublishingHouseCreateDto;
use App\Http\Requests\PublishingHouse\PublishingHouseUpdateDto;

class PublishingHouseController extends Controller
{
    public function __construct(private PublishingHouseService $publishingHouseService) {}

    public function index(SortRequest $request): JsonResponse
    {
        return response()->json(PublishingHouseResource::collection(
            $this->publishingHouseService->getAll($request)
        ));
    }

    public function show($id): JsonResponse
    {
        return response()->json(
            new PublishingHouseResource(
                $this->publishingHouseService->find($id)
            )
        );
    }

    public function store(PublishingHouseCreateDto $dto): JsonResponse
    {
        return response()->json(new PublishingHouseResource(
            $this->publishingHouseService->store($dto)
        ));
    }

    public function update(PublishingHouseUpdateDto $dto, int $id): JsonResponse
    {
        $publishingHouse = $this->publishingHouseService->find($id);

        $this->authorize('update', $publishingHouse);

        return response()->json(new PublishingHouseResource(
            $this->publishingHouseService->update($dto, $publishingHouse)
        ));
    }

    public function destroy(int $id): void
    {
        $publishingHouse = $this->publishingHouseService->find($id);

        $this->authorize('update', $publishingHouse);

        $this->publishingHouseService->destroy($publishingHouse);
    }
}
