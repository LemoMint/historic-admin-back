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

    public function all(): Collection
    {
        return $this->getStartConditions()->get();
    }

    public function find(int $id): ?Model
    {
        return $this->getStartConditions()->find($id);
    }
    // private function getAll(): Builder
    // {
    //     //todo expand the number of fields
    //     $fields = [
    //         'id',
    //         'name',
    //         'surname',
    //         'patronymic_name'
    //     ];

    //     return $this->startConditions()->select($fields);
    // }

    // private function getStartConditions()
    // {
    //     return  $this->startConditions()->select($this->selectFields);
    // }
}
