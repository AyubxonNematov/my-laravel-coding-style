<?php

namespace Modules\Catalog\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Catalog\Http\Services\CategoryService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Catalog\Http\Requests\Categories\CategoryStoreRequest;
use Modules\Catalog\Http\Requests\Categories\CategoryUpdateRequest;
use Modules\Catalog\Http\Resources\Categories\CategoryFullResource;
use Modules\Catalog\Http\Resources\Categories\CategoryShortResource;
use Modules\Catalog\Http\Resources\Categories\CategoryMediumResource;

class CategoryController 
{
    public function __construct(public CategoryService $service) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        return CategoryMediumResource::collection( 
            $this->service->pagination($request->all()) 
        );
    }

    public function show(Request $request , $id): CategoryFullResource
    {   
        $request->validate(['with' => 'string']);
        return new CategoryFullResource(
            $this->service->getModelById($id)
        );
    }

    public function store(CategoryStoreRequest $request): CategoryMediumResource
    {
        return new CategoryMediumResource(
            $this->service->createModel($request->all())
        );
    }
 
    public function update(CategoryUpdateRequest $request, $id): CategoryMediumResource
    {
        return new CategoryMediumResource(
            $this->service->updateModel($request->all(), $id)
        );
    }

    public function destroy($id): CategoryMediumResource
    {
        return new CategoryMediumResource(
            $this->service->deleteModel($id)
        );
    }
    
    public function getTree(): AnonymousResourceCollection
    {
        return CategoryShortResource::collection( $this->service->getTree() );
    }
   
    public function getBreadcrumbs($leafCategory): AnonymousResourceCollection
    {
        return CategoryShortResource::collection( 
            $this->service->getBreadcrumbs($leafCategory) 
        );
    }

    public function search($search): AnonymousResourceCollection
    {
        return CategoryShortResource::collection( 
            $this->service->searchModel('name', $search)
        );
    }
}
