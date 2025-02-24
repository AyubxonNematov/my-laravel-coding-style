<?php

namespace App\Services;

use App\Interfaces\IBaseService;
use App\Models\BaseModel;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

abstract class BaseService implements IBaseService
{
    protected BaseRepository $repository;

    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function pagination($data = []): LengthAwarePaginator
    {
        return $this->repository->pagination($data);
    }

    public function collection($data = []): Collection
    {
        return $this->repository->collection($data);
    }

    public function searchModel(string|array $column, string $value ): Collection
    {
        return $this->repository->search($column, $value);
    }

    public function createModel($data): BaseModel
    {
        return $this->repository->create($data);
    }

    public function updateModel($data, $id): BaseModel
    {
        return $this->repository->update($data, $id);
    }

    public function deleteModel($id): BaseModel
    {
        return $this->repository->delete($id);
    }

    public function getModelById($id): BaseModel
    {
        return $this->repository->findById($id);
    }
}
