<?php


namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

abstract class CoreRepository
{
    protected Model $model;
    protected array $selectFields = [];
    protected array $with = [];

    public function __construct()
    {
        $this->model = app($this->getModelClass());
    }
    abstract protected function getModelClass(): string;
    protected function startConditions(): Model
    {
        return clone $this->model;
    }
    protected function getStartConditions(): Builder
    {
        return  $this->startConditions()->with($this->with)->select($this->selectFields);
    }
}
