<?php

namespace Modules\Catalog\Http\Services;

use App\Services\BaseService;
use Modules\Catalog\Http\Repositories\OptionRepository;

class OptionService extends BaseService
{
    public function __construct(OptionRepository $repository)
    {
        parent::__construct($repository);
    }
}
