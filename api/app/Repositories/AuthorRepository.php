<?php


namespace App\Repositories;

use App\Models\Author as Model;
use App\Http\Requests\SortRequest;
use Illuminate\Database\Eloquent\Collection;

class AuthorRepository extends CoreRepository
{
    protected array $selectFields = [
        'id',
        'name',
        'surname',
        'patronymic_name',
        'created_at',
        'updated_at',
        'user_id'
    ];

    protected function getModelClass(): string
    {
        return Model::class;
    }

    public function all(SortRequest $params): Collection
    {
        $startConditions = $this->getStartConditions();

        if ($params->get('_search')) {
            $search = $params->get('_search');
            $startConditions->where('surname', 'ilike', '%'.$search.'%')
                ->orWhere('name', 'ilike', '%'.$search.'%')
                ->orWhere('patronymic_name', 'ilike', '%'.$search.'%');
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
