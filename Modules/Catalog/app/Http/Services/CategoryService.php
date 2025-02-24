<?php

namespace Modules\Catalog\Http\Services;

use App\Models\BaseModel;
use Illuminate\Support\Str;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Collection;
use Modules\Catalog\Http\Repositories\CategoryRepository;

class CategoryService extends BaseService
{
    public function __construct(CategoryRepository $repository)
    {
        parent::__construct($repository);
    }

    public function createModel($data): BaseModel
    {
        $data['slug'] = Str::slug($data['name']['en']);
        $model = $this->repository->create($data);

        if (isset($data['parent_id'])) {
            $parent = $this->repository->findById($data['parent_id']);
            $model->appendToNode($parent)->save();
        }

        return $model;
    }

    public function updateModel($data, $id): BaseModel
    {
        if (isset($data['name']['en'])) {
            $data['slug'] = Str::slug($data['name']['en']);
        }
   
        $model = $this->repository->update($data, $id);

        if (isset($data['parent_id'])) {
            $parent = $this->repository->findById($data['parent_id']);
            $model->appendToNode($parent)->save();
        }

        return $model;
    }

    public function getTree(): Collection
    {
        return $this->repository->collection()->toTree();
    }
 
    public function getBreadcrumbs($leafCategory): Collection
    {
        return $this->repository->getBreadcrumbs($leafCategory);
    }
}
