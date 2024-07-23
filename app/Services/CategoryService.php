<?php

namespace App\Services;

use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;

/**
 *
 */
class CategoryService
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        return Category::query()
            ->orderBy($request->input('sort.0.key', 'created_at'), $request->input('sort.0.order', 'desc'))
            ->paginate($request->input('per_page', 10));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(Request $request)
    {
        return Category::all();
    }

    /**
     * @param CategoryRequest $request
     * @return mixed
     */
    public function store(CategoryRequest $request)
    {
        return Category::create($request->all());
    }

    /**
     * @param CategoryRequest $request
     * @param Category $category
     * @return Category
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->all());
        return $category;
    }

    /**
     * @param Category $category
     * @return void
     */
    public function destroy(Category $category)
    {
        $category->delete();
    }
}
