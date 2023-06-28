<?php

namespace App\Http\Controllers\Api;

use App\Services\AuthorService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorResource;
use App\Http\Requests\Author\AuthorCreateDto;
use App\Http\Requests\Author\AuthorUpdateDto;
use App\Http\Requests\SortRequest;

class AuthorController extends Controller
{
    public function __construct(private AuthorService $authorService) {}

    public function index(SortRequest $search): JsonResponse
    {
        return response()->json(AuthorResource::collection(
            $this->authorService->getAll($search)
        ));
    }

    public function show($id): JsonResponse
    {
        return response()->json(
            new AuthorResource(
                $this->authorService->find($id)
            )
        );
    }

    public function store(AuthorCreateDto $dto): JsonResponse
    {
        return response()->json(new AuthorResource(
            $this->authorService->store($dto)
        ));
    }

    public function update(AuthorUpdateDto $dto, int $id): JsonResponse
    {
        $author = $this->authorService->find($id);

        $this->authorize('update', $author);

        return response()->json(new AuthorResource(
            $this->authorService->update($dto, $author)
        ));
    }

    public function destroy(int $id): void
    {
        $author = $this->authorService->find($id);

        $this->authorize('update', $author);

        $this->authorService->destroy($author);
    }
}
