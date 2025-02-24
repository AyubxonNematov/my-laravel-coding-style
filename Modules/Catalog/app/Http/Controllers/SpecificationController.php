<?php

namespace Modules\Catalog\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Catalog\Http\Services\SpecificationService;
use Modules\Catalog\Http\Requests\Specifications\SpecificationStoreRequest;
use Modules\Catalog\Http\Requests\Specifications\SpecificationUpdateRequest;
use Modules\Catalog\Http\Resources\Specifications\SpecificationFullResource;

class SpecificationController 
{
    public function __construct(public SpecificationService $service) {}

    public function index(Request $request)
    {
        return SpecificationFullResource::collection( 
            $this->service->pagination($request->all()) 
        );
    }

    public function store(SpecificationStoreRequest $request): SpecificationFullResource
    {
        return new SpecificationFullResource(
            $this->service->createModel($request->all())
        );
    }
 
    public function update(SpecificationUpdateRequest $request, $id): SpecificationFullResource
    {
        return new SpecificationFullResource(
            $this->service->updateModel($request->all(), $id)
        );
    }

    public function destroy($id): SpecificationFullResource
    {
        return new SpecificationFullResource(
            $this->service->deleteModel($id)
        );
    }
}
