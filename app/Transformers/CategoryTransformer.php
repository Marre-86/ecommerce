<?php

namespace App\Transformers;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    public function transform(Category $category)
    {
        $item = [
            'id' => (int) $category->id,
            'name' => $category->name,
            'parent_id' => $category->parent_id,
            'grandparent_id' => $category->grandparent_id,
        ];
        foreach ($category->childrenWithGrandchildren as $child) {
            $item['children'][] = $this->transform($child);
        }
        return $item;
    }
}
