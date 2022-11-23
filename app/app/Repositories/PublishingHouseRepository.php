<?php


namespace App\Repositories;

use App\Models\PublishingHouse as Model;
use Illuminate\Database\Eloquent\Collection;

class PublishingHouseRepository extends CoreRepository
{
    protected array $selectFields = [
        'id',
        'name',
        'address',
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
            $startConditions->where('name', 'ilike', '%'.$search.'%');
        }

        return $startConditions->get();
    }

    public function find(int $id): ?Model
    {
        return $this->getStartConditions()->find($id)->first();
    }
}
