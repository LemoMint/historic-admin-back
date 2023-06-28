<?php


namespace App\Repositories;

use App\Http\Requests\SortRequest;
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
        'authors',
        'categories'
    ];

    protected function getModelClass(): string
    {
        return Model::class;
    }

    public function all(SortRequest $params, bool $isAdmin = false): Collection
    {
        $startConditions = $this->getStartConditions();

        if ($params->get('_search')) {
            $startConditions = $startConditions->where('name', 'like', '%'.$params->get('_search').'%');
        }

        if ($params->get('_sortBy') && $params->get('_sortOrder')) {
            $startConditions = $startConditions->orderBy(
                $params->get('_sortBy'), $params->get('_sortOrder')
            );
        }

        if (null !== $filters = $params->get('_filter')) {
            foreach($filters as $field => $value) {
                if (is_array($value)) {
                    $startConditions = $startConditions->whereHas($field, function($q) use ($value) {
                        $q->whereIn('id', $value);
                    });
                } else {
                    $startConditions = $startConditions->where($field, $value);
                }
            }
        }

        if (!$isAdmin) {
            $startConditions->where('deleted_at', null);
        }

        return $startConditions->get();
    }

    public function find(int $id, bool $isAdmin = false): ?Model
    {
        $sc =  $this->getStartConditions();

        if ($isAdmin) {
            $sc->withTrashed();
        }

        return $sc->find($id);
    }
}
