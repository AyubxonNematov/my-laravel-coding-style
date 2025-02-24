<?php

use App\Controllers\EnumController;
use Illuminate\Support\Facades\Route;

Route::get('/enums/statuses', [EnumController::class, 'getStatuses']);
Route::get('/enums/types', [EnumController::class, 'getTypes']);
