<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Product::orderBy('id', 'desc')->paginate(5);
        return view('items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $item = new Product();

        $categories = Category::whereNull('parent_id')->get();

        return view('items.create', ['item' => $item, 'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $item = new Product();

        $data = $this->validate($request, [
            'name' => 'min:3|max:64|unique:products',
            'category_id' => 'required',
            'price' => 'required',
            'description' => 'nullable|max:400']);
        $item->fill($data);
        $item->save();

        flash('Item has been successfully created!')->success();
        return redirect()->route('items.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $item)
    {
        $item = Product::findOrFail($item->id);
        return view('items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $item)
    {
        $categories = Category::whereNull('parent_id')->get();

        return view('items.edit', ['item' => $item, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
