<?php

namespace App\Http\Controllers\Api\V1;

use App\Transformers\CategoryTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use App\Http\Controllers\Api\V1\BaseController;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends BaseController
{
    public function tree()
    {
        $categories = Category::whereNull('parent_id')->with('childrenWithGrandchildren')->get();
        $resource = new Collection($categories, new CategoryTransformer());
        $fractal = new Manager();
        // using current() here in order to remove Fractal in-built 'data' key
        $categoryTree = current($fractal->createData($resource)->toArray());
        return $this->sendResponse($categoryTree, 'Categories retrieved successfully.');
    }

    public function store(Request $request)
    {

        try {
            $parent = Category::where('id', $request->input('parent_id'))->first();
            $newCategory = isset($parent->parent_id) ? $request->toArray() + ['grandparent_id' => $parent->parent_id] : $request->toArray() + ['parent_id' => null, 'grandparent_id' => null];   // phpcs:ignore
            $newCategoryStored = Category::create($newCategory);
            $newCategory = ['id' => $newCategoryStored['id']] + $newCategory;
        } catch (\Illuminate\Database\QueryException $exception) {
            return $this->sendError('Bad request.', ['error' => 'Bad request. Probably not enough of required fields'], 400);   // phpcs:ignore
        }

        return $this->sendResponse($newCategory, 'Category added successfully.', 201);
        return response()->json($newCategory, 201);
    }
}
