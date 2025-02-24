<?php

namespace Modules\Catalog\Http\Repositories;

use App\Repositories\BaseRepository;
use Modules\Catalog\Models\Option;

class OptionRepository extends BaseRepository
{
    public function __construct(Option $model)
    {
        parent::__construct($model);
    }  
}
