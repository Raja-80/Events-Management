<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    //
    function __construct()
    {
         $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
         $this->middleware('permission:product-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    public function index($slug = null)
    {
        $query = $slug ? Category::whereSlug($slug)->firstOrFail()->products() : Product::query();
        $products = $query->withTrashed()->oldest('name')->paginate(5);
        $categories = Category::all();
        
        return view('products.index', compact('products', 'categories', 'slug'));
    }
    

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
        
    }
        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = new Product;
        $product->name = $data['name'];
        $product->description = $data['description'];
        $product->price = $data['price'];
        $product->category_id = $data['category_id'];
      

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images', $filename);
            $product->image = $filename;
        }

        $product->save();
        Log::channel('journal')->info('The product'.'  '.$request->input('name').' created successfully');
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }


    public function show(Product $product)
    {
        $category = $product->category->name;
        return view('products.show', compact('product', 'category'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('products.edit', compact('product','categories'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Storage::putFileAs('public/images', $image, $filename);
            Storage::delete('public/images/' . $product->photo);
            $validatedData['image'] = $filename;
        } else {
            $validatedData['image'] = $product->photo;
        }

        $product->update($validatedData);
        Log::channel('journal')->info('The product'.'  '.$request->input('name').' updated successfully');
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        Storage::delete('public/images/' . $product->photo);
        $product->delete();
        Log::channel('journal')->info('The product'.'  '.$product->name.' deleted successfully');
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function forceDestroy($id)
    {
        Product::withTrashed()->whereId($id)->firstOrFail()->forceDelete();

        Log::channel('journal')->info('The product id= '.$id.' has been permanently deleted from the database');
        
        return back()->with('success', 'The Product has been permanently deleted from the database.');
    }
    public function restore($id)
    {
        Product::withTrashed()->whereId($id)->firstOrFail()->restore();
        Log::channel('journal')->info('The product id= '. $id .'  has been successfully restored');
        return back()->with('success', 'The Product has been successfully restored.');
    }
}
