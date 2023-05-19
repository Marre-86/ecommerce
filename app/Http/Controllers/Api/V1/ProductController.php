<?php

namespace App\Http\Controllers\Api\V1;

use App\Transformers\CategoryTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use App\Http\Controllers\Api\V1\BaseController;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends BaseController
{
    public function index()
    {
        $products = Product::all();
        return $this->sendResponse($products, 'Products retrieved successfully.');
    }
}
