<?php


namespace App\Repositories;

use App\Models\Author as Model;
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

    public function all(?string $search): Collection
    {
        $startConditions = $this->getStartConditions();

        if ($search) {
            $startConditions->where('surname', 'like', $search.'%')
                ->orWhere('name', 'like', $search.'%')
                ->orWhere('patronymic_name', 'like', $search.'%');
        }

        return $startConditions->get();
    }

    public function find(int $id): ?Model
    {
        return $this->getStartConditions()->find($id);
    }
}
