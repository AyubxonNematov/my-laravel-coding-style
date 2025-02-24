<?php

namespace Modules\Catalog\Http\Repositories;

use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Modules\Catalog\Models\Category;

class CategoryRepository extends BaseRepository
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function getBreadcrumbs(string $leafCategory): Collection
    {
        return $this->findById($leafCategory)->ancestors()->get();
    }
}
