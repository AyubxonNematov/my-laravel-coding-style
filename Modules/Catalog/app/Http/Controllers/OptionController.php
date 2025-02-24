<?php

namespace Modules\Catalog\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Catalog\Http\Services\OptionService;
use Modules\Catalog\Http\Requests\Options\OptionStoreRequest;
use Modules\Catalog\Http\Requests\Options\OptionUpdateRequest;
use Modules\Catalog\Http\Resources\Options\OptionFullResource;

class OptionController 
{
    public function __construct(public OptionService $service) {}

    public function index(Request $request)
    {
        return OptionFullResource::collection( 
            $this->service->pagination($request->all()) 
        );
    }

    public function store(OptionStoreRequest $request): OptionFullResource
    {
        return new OptionFullResource(
            $this->service->createModel($request->all())
        );
    }
 
    public function update(OptionUpdateRequest $request, $id): OptionFullResource
    {
        return new OptionFullResource(
            $this->service->updateModel($request->all(), $id)
        );
    }

    public function destroy($id): OptionFullResource
    {
        return new OptionFullResource(
            $this->service->deleteModel($id)
        );
    }
}
