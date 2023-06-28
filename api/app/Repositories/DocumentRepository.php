<?php


namespace App\Repositories;

use App\Models\Author as Model;
use Illuminate\Database\Eloquent\Collection;

class DocumentRepository extends CoreRepository
{
    protected array $selectFields = [
        'id',
        'file_name',
        'disk',
        'extension'
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
