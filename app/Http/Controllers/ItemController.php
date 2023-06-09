<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

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
            'price' => 'required|gte:0',
            'length' => 'nullable',
            'weight' => 'nullable',
            'width' => 'nullable',
            'description' => 'nullable|max:400',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,bmp|max:1024'
        ]);

        $item->fill($data);
        $item->save();

        if ($request->has('image')) {
            $fileName = $item->slug . '.' . $request->image->extension();
            $request->image->storeAs('public/images', $fileName);
            $item->image = $fileName;
            $item->save();
        }

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
        $item = Product::findOrFail($item->id);

        $oldName = $item->name;

        $data = $this->validate($request, [
            'name' => 'min:3|max:64|unique:products,name,' . $item->id,
            'category_id' => 'required',
            'price' => 'required|gte:0',
            'length' => 'nullable',
            'weight' => 'nullable',
            'width' => 'nullable',
            'description' => 'nullable|max:400',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,bmp|max:1024']);
        $item->fill($data);
        $item->save();
           // renaming image in accordance with a new item name
        if ($oldName !== $request->input('name')) {
            $oldFilePath = 'public/images/' . $item->image;
            $newFileName = $item->slug . '.' . pathinfo($item->image, PATHINFO_EXTENSION);
            $newFilePath = 'public/images/' . $newFileName;
            if (Storage::exists($oldFilePath)) {
                Storage::move($oldFilePath, $newFilePath);
            }
            $item->image = $newFileName;
            $item->save();
        }
            // overwriting image file with a new one
        if ($request->has('image')) {
            $fileName = $item->slug . '.' . $request->image->extension();
            $request->image->storeAs('public/images', $fileName);
            $item->image = $fileName;
            $item->save();
        }     // i see the potential gap here in case new file has another extension
                // it won't be overwritten, it will be just added and the old file will stay

        flash('Item has been successfully updated!')->success();
        return redirect()->route('items.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $item)
    {
        $item = Product::findOrFail($item->id);

        if ($item->orders->isNotEmpty()) {
            flash('Item can\'t be deleted because it has been ordered at least once!')->error();
            return redirect()->route('items.index');
        }

        if ($item->image !== null) {
            $imageFilePath = 'public/images/' . $item->image;
            if (Storage::exists($imageFilePath)) {
                Storage::delete($imageFilePath);
            }
        }

        $item->delete();

        flash('Item has been successfully deleted!')->success();
        return redirect()->route('items.index');
    }
}
