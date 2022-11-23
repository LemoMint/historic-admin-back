<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\PublishingHouseService;
use App\Http\Resources\PublishingHouseResource;
use App\Http\Requests\PublishingHouse\PublishingHouseCreateDto;
use App\Http\Requests\PublishingHouse\PublishingHouseUpdateDto;

class PublishingHouseController extends Controller
{
    public function __construct(private PublishingHouseService $publishingHouseService) {}

    public function index(Request $request): JsonResponse
    {
        $search = $request->query('_search');

        return response()->json(PublishingHouseResource::collection(
            $this->publishingHouseService->getAll($search)
        ));
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
