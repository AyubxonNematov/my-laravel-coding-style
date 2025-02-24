<?php

namespace Modules\Catalog\Http\Services;

use App\Services\BaseService;
use Modules\Catalog\Http\Repositories\SpecificationRepository;

class SpecificationService extends BaseService
{
    public function __construct(SpecificationRepository $repository)
    {
        parent::__construct($repository);
    }
}
