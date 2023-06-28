<?php


namespace App\Repositories;

use App\Models\Category as Model;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\SortRequest;

class CategoryRepository extends CoreRepository
{
    protected array $selectFields = [
        'id',
        'name',
        'created_at',
        'updated_at',
        'user_id'
    ];

    protected array $with = [
        'publications', 'user'
    ];

    protected function getModelClass(): string
    {
        return Model::class;
    }

    public function all(SortRequest $params): Collection
    {
        $startConditions = $this->getStartConditions();

        if ($params->get('_search')) {
            $startConditions->where('name', 'like', '%'.$params->get('_search').'%');
        }

        if ($params->get('_sortBy') && $params->get('_sortOrder')) {
            $startConditions->orderBy(
                $params->get('_sortBy'), $params->get('_sortOrder')
            );
        }

        return $startConditions->get();
    }

    public function find(int $id): ?Model
    {
        return $this->getStartConditions()->find($id);
    }
}
