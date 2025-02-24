<?php

use Illuminate\Support\Facades\Route;

Route::get('/docs', function () {
    return redirect('/docs/api');
});

Route::get('/up-tenants', function () {
    // for test 
    $tenant1 = App\Models\Tenant::create(['id' => 'uzb']);
    $tenant1->domains()->create(['domain' => 'products-service-uz.pollwon.local']);

    $tenant1 = App\Models\Tenant::create(['id' => 'kaz']);
    $tenant1->domains()->create(['domain' => 'products-service-kz.pollwon.local']);
});

require __DIR__.'/tenant.php';