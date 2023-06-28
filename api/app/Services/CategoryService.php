<?php

namespace App\Services;

use App\Models\Category;
use App\Http\Requests\SortRequest;
use App\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\Category\CategoryCreateDto;
use App\Http\Requests\Category\CategoryUpdateDto;

class CategoryService
{
    public function __construct(private CategoryRepository $categoryRepository) {}

    public function getAll(SortRequest $params): Collection
    {
        return $this->categoryRepository->all($params);
    }

    public function find(int $id): ?Category
    {
        return $this->categoryRepository->find($id);
    }

    public function store(CategoryCreateDto $dto): Category
    {
        $category = new Category($dto->safe()->all());

        $category->save();

        return $category;
    }

    public function update(CategoryUpdateDto $dto, Category $category)
    {
        $category->fill($dto->safe()->all());

        $category->save();

        return $category;
    }

    public function destroy(Category $category)
    {
        Category::destroy($category->id);
    }
}
