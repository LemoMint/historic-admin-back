<?php


namespace App\Repositories;

use App\Models\Author as Model;
use Illuminate\Database\Eloquent\Collection;

class PublishingHouseRepository extends CoreRepository
{
    protected array $selectFields = [
        'id',
        'name',
        'description',
        'isImmutable',
        'created_at',
        'updated_at',
        'user_id'
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
