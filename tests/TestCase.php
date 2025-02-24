<?php

namespace Tests;

use App\Models\Tenant;
use Tests\CreatesApplication;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Str;

class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $tenant;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Accept-Language' => 'en',
        ]);

        if ($this->isTenancyTest()) {
            $this->initializeTenancy();
        }
    }

    protected function isTenancyTest(): bool
    {
        $className = get_class($this); 
        return str_contains($className, 'Tests\\Tenancy\\'); 
    }

    protected function initializeTenancy(): void
    {
        $tenantId = 'tenant_' . Str::random(8);

        $this->tenant = Tenant::create(['id' => $tenantId]);

        tenancy()->initialize($this->tenant);

        $this->tenant->run(function () {
            $this->artisan('tenants:migrate');
        });
    }

    protected function tearDown(): void
    {
        if (tenancy()->initialized) {
            tenancy()->end();
            if ($this->tenant) {
                $this->tenant->delete(); 
            }
        }

        parent::tearDown();
    }

    protected function refreshTestDatabase()
    {
        if (tenancy()->initialized) {
            $this->tenant->run(function () {
                $this->artisan('migrate:fresh', ['--database' => 'tenant']);
            });
        }

        parent::refreshTestDatabase();
    }
}