<?php


namespace App\Repositories;

use App\Models\Author as Model;
use Illuminate\Database\Eloquent\Collection;

class RoleRepository extends CoreRepository
{
    protected array $selectFields = [
        'id',
        'name',
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
        return $this->getStartConditions()->find($id)->first();
    }
}
