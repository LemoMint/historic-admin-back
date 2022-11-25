<?php


namespace App\Repositories;

use App\Models\Publication as Model;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\Publication\PublicationSortRequest;

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

    public function all(PublicationSortRequest $params): Collection
    {
        $startConditions = $this->getStartConditions();

        if ($params->get('_search')) {
            $startConditions->where('name', 'like', '%'.$params->get('_search').'%');
        }

        if ($params->get('_sortBy') && $params->get('_sortOrder')) {
            $startConditions->orderBy(
                $params->get('_sortBy'), $params->get('_sortOrder')
            );
        }

        return $startConditions->where('deleted_at', null)->get();
    }

    public function find(int $id): ?Model
    {
        return $this->getStartConditions()->withTrashed()->find($id);
    }
}
