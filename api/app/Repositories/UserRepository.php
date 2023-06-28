<?php


namespace App\Repositories;

use App\Models\User as Model;
use App\Http\Requests\SortRequest;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends CoreRepository
{
    protected array $selectFields = [
        'id',
        'name',
        'surname',
        'patronymic_name',
        'email',
        'created_at',
        'updated_at',
        'deleted_at',
        'role_id'
    ];

    protected array $with = [
        'role'
    ];


    protected function getModelClass(): string
    {
        return Model::class;
    }

    public function all(SortRequest $params, bool $isAdmin = false): Collection
    {
        $startConditions = $this->getStartConditions();

        if ($params->get('_search')) {
            $search = $params->get('_search');
            $startConditions->where('name', 'like', '%'.$search.'%')
                ->orWhere('email', 'ilike', '%'.$search.'%');
        }

        if ($params->get('_sortBy') && $params->get('_sortOrder')) {
            $startConditions->orderBy(
                $params->get('_sortBy'), $params->get('_sortOrder')
            );
        }

        if ($isAdmin) {
            $startConditions->withTrashed();
        }

        return $startConditions->get();
    }

    public function find(int $id, bool $isAdmin = false): ?Model
    {
        $startConditions =  $this->getStartConditions();

        if ($isAdmin) {
            $startConditions->withTrashed();
        }

        return $startConditions->find($id);
    }
}
