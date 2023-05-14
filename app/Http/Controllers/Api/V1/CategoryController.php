<?php

namespace App\Http\Controllers\Api\V1;

use App\Transformers\CategoryTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function tree()
    {

        $categories = Category::whereNull('parent_id')->with('childrenWithGrandchildren')->get();
        $resource = new Collection($categories, new CategoryTransformer());
        $fractal = new Manager();
        return $fractal->createData($resource)->toJson();
    }
}
