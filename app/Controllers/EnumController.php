<?php

namespace App\Controllers;

use App\Dtos\ApiResponse;
use App\Enums\StatusEnum;
use App\Enums\GoodsTypeEnum;

class EnumController 
{
    public function getStatuses()
    {
       return ApiResponse::success(StatusEnum::getList());
    }

    public function getTypes()
    {
       return ApiResponse::success(GoodsTypeEnum::getList());
    }
}
