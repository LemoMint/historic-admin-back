<?php


namespace App\Repositories;

use App\Models\Role as Model;
use Illuminate\Database\Eloquent\Collection;

class RoleRepository extends CoreRepository
{
    protected array $selectFields = [
        'id',
        'name',
        'lable',
        'description',
        'isImmutable',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected function getModelClass(): string
    {
        return Model::class;
    }

    public function all(): Collection
    {
        return $this->getStartConditions()->get();
    }

    public function find(int $id): ?Model
    {
        return $this->getStartConditions()->find($id);
    }
}
