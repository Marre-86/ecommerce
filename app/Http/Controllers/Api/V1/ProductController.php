<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\BaseController;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends BaseController
{
    private function addCategoryNameAndRoundUpAPrice($products)
    {
        $categories = Category::all();
        $products->map(function ($product) use ($categories) {
            $categoryName = $categories->where('id', $product['category_id'])->pluck('name')->first();
            $categoryParentId = $categories->where('id', $product['category_id'])->pluck('parent_id')->first();
            $categoryParentName = $categories->where('id', $categoryParentId)->pluck('name')->first();
            $categoryGrandparentId = $categories->where('id', $product['category_id'])->pluck('grandparent_id')->first();  // phpcs:ignore
            $categoryGrandparentName = $categories->where('id', $categoryGrandparentId)->pluck('name')->first();
            $product['category_name'] = ltrim("$categoryGrandparentName/{$categoryParentName}/{$categoryName}", "/");
            $product['price'] = (float) number_format((float)$product['price'], 2, '.', '');
            $product['length'] = (float) $product['length'];
            $product['weight'] = (float) $product['weight'];
            $product['width'] = (float) $product['width'];
            return $product;
        });
        return $products;
    }

    public function index(Request $request)
    {
        $filter = $request->query('filter');

        if (is_array($filter)) {
            $query = Product::query();

            if (isset($filter['name'])) {
                $query->whereRaw("UPPER(name) LIKE '%" . strtoupper($filter['name']) . "%'");
            }
            if (isset($filter['category_id'])) {
                $query->where('category_id', $filter['category_id']);
            }
            if (isset($filter['price-gte'])) {
                $query->where('price', '>', $filter['price-gte']);
            }
            if (isset($filter['price-lte'])) {
                $query->where('price', '<', $filter['price-lte']);
            }
            if (isset($filter['weight'])) {
                $query->where('weight', $filter['weight']);
            }
            if (isset($filter['length'])) {
                $query->where('length', $filter['length']);
            }
            if (isset($filter['width'])) {
                $query->where('width', $filter['width']);
            }

            $products = $query->orderBy('id')->get();
            $productsWithCatNames = $this->addCategoryNameAndRoundUpAPrice($products);
            if ($productsWithCatNames->isEmpty()) {
                return $this->sendResponse($productsWithCatNames, 'No items with these parameters.');
            }
            return $this->sendResponse($productsWithCatNames, 'Products retrieved successfully.');
        }

        $products = $this->addCategoryNameAndRoundUpAPrice(Product::all());

        return $this->sendResponse($products, 'Products retrieved successfully.');
    }
}
