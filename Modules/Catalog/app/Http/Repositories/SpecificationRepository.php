<?php

namespace Modules\Catalog\Http\Repositories;

use App\Repositories\BaseRepository;
use Modules\Catalog\Models\Specification;

class SpecificationRepository extends BaseRepository
{
    public function __construct(Specification $model)
    {
        parent::__construct($model);
    }  
}
