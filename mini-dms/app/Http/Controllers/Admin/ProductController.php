<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // show all products
    public function index()
    {
        $products = Product::paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|string',
            'description'=>'nullable|string',
            'price'=>'required|numeric|min:0',
            'stock'=>'required|integer|min:0'
        ]);

        Product::create($data);
        return redirect()->route('admin.products.index')->with('success','Product added');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'=>'required|string',
            'description'=>'nullable|string',
            'price'=>'required|numeric|min:0',
            'stock'=>'required|integer|min:0'
        ]);
        $product->update($data);
        return redirect()->route('admin.products.index')->with('success','Product updated');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success','Product deleted');
    }
}
