<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

/**
 *
 */
class CategoryController extends Controller
{
    /**
     * @param CategoryService $service
     */
    public function __construct(protected CategoryService $service)
    {
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $response = $this->service->index($request);
        return CategoryResource::collection($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function all(Request $request)
    {
        $response = $this->service->all($request);
        return CategoryResource::collection($response);
    }

    /**
     * @param CategoryRequest $request
     * @return CategoryResource
     */
    public function store(CategoryRequest $request)
    {
        $response = $this->service->store($request);
        return new CategoryResource($response);
    }

    /**
     * @param CategoryRequest $request
     * @param Category $category
     * @return CategoryResource
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $response = $this->service->update($request, $category);
        return new CategoryResource($response);
    }

    /**
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category)
    {
        $this->service->destroy($category);
        return response()
            ->json([
                'success' => true,
                'message' => 'Category deleted'
            ]);
    }
}
