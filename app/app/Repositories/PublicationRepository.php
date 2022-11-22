<?php


namespace App\Repositories;

use App\Models\Publication as Model;
use Illuminate\Database\Eloquent\Collection;

class PublicationRepository extends CoreRepository
{
    protected array $selectFields = [
        'id',
        'name',
        'description',
        'user_id',
        'publication_year',
        'publication_century',
        'publishing_house_id',
        'document_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected array $with = [
        'document',
        'user',
        'authors'
    ];

    protected function getModelClass(): string
    {
        return Model::class;
    }

    public function all(): Collection
    {
        $a = $this->getStartConditions();
        $c = $a->get();
        return $this->getStartConditions()->get();
    }

    public function find(int $id): ?Model
    {
        return $this->getStartConditions()->find($id);
    }
}
