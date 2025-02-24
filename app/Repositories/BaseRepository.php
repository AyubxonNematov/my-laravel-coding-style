<?php

namespace App\Repositories;

use App\Enums\SearchEnum;
use App\Models\BaseModel;
use App\Enums\PaginationEnum;
use App\Interfaces\IBaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\{Builder, Collection, Model};

abstract class BaseRepository implements IBaseRepository
{
    protected Model $modelClass;

    public function __construct(Model $modelClass)
    {
        $this->modelClass = $modelClass;
    }

    public function pagination($data = [], array|string $with = null): LengthAwarePaginator
    {
        $query = $this->query();
        if (method_exists($this->getModel(), 'scopeFilter'))
            $query->filter($data);

        if (!is_null($with))
            $query->with($with);

        return $query->paginate(
            (int) request()->perPage ?? PaginationEnum::PER_PAGE
        );
    }

    public function collection($data = [], array|string $with = null): Collection
    {
        $query = $this->query();
        if (method_exists($this->getModel(), 'scopeFilter'))
            $query->filter($data);

        if (!is_null($with))
            $query->with($with);

        return $query->get();
    }

    public function search(string|array $column, string $value ): Collection
    {
        return $this->query()
            ->where(function (Builder $query) use ($column, $value) {
                $query->where($column, 'like', "%$value%");
                if (is_array($column)) {
                    foreach ($column as $col) {
                        $query->orWhere($col, 'like', "%$value%");
                    }
                }
            })
            ->take(SearchEnum::PER_PAGE)
            ->get();
    }

    protected function query(): Builder
    {
        $query = $this->getModel()->newQuery();
        return $query->orderByDesc('id');
    }
    

    protected function getModel(): Model
    {
        return $this->modelClass;
    }

    public function create($data): BaseModel
    {
        $model = $this->getModel();
        $model->fill($data);
        $model->save();
        return $model;
    }

    public function update($data, $id): BaseModel
    {
        $model = $this->query()->findOrFail($id);
        $model->fill($data);
        $model->save();
        return $model;
    }

    public function findById($id): BaseModel
    {
        $query = $this->query();
        
        if (method_exists($this->getModel(), 'scopeFilter')) {
            $query = $query->filter(request()->all());
        }

        return $query->findOrFail($id);
    }

    public function delete($id): BaseModel
    {
        $model = $this->query()->findOrFail($id);
        $model->delete();
        return $model;
    }
}
