<?php

namespace Modules\Catalog\Http\Controllers;

use App\Dtos\ApiResponse;
use Modules\Catalog\Enum\SpecificationTypeEnum;

class EnumController 
{
    public function getSpecificationTypes()
    {
        return ApiResponse::success(SpecificationTypeEnum::cases()); 
    }
}
