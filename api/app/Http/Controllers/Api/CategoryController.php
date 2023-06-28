<?php

namespace App\Http\Controllers\Api;

use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\SortRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\Category\CategoryCreateDto;
use App\Http\Requests\Category\CategoryUpdateDto;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService) {}

    public function index(SortRequest $sortRequest): JsonResponse
    {
        return response()->json(CategoryResource::collection(
            $this->categoryService->getAll($sortRequest)
        ));
    }

    public function show($id): JsonResponse
    {
        return response()->json(
            new CategoryResource(
                $this->categoryService->find($id)
            )
        );
    }

    public function store(CategoryCreateDto $dto): JsonResponse
    {
        return response()->json(new CategoryResource(
            $this->categoryService->store($dto)
        ));
    }

    public function update(CategoryUpdateDto $dto, int $id): JsonResponse
    {
        $category = $this->categoryService->find($id);

        $this->authorize('update', $category);

        return response()->json(new CategoryResource(
            $this->categoryService->update($dto, $category)
        ));
    }

    public function destroy(int $id): void
    {
        $category = $this->categoryService->find($id);

        $this->authorize('update', $category);

        $this->categoryService->destroy($category);
    }
}
