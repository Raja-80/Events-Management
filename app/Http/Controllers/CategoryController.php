<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
         $this->middleware('permission:product-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
   

     public function index(Request $request)
{
    $query = Category::query();

    if ($request->has('search')) {
        $query->where('name', 'like', '%' . $request->input('search') . '%');
    }

    $categories = $query->orderBy('name')->paginate(5);

    return view('categories.index', compact('categories'));
}

     
     


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|unique:categories|max:255',
    ]);

    $category =new Category;
    $category->name=$validatedData['name'];
    $category->slug = Str::slug($validatedData['name']);
    $category->save();

    Log::channel('journal')->info('The Category'.'  '.$request->input('name').' created successfully');

    return redirect()->route('categories.index')->with('success', 'Category created successfully.');
}

    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id . '|max:255',
        ]);

        $category->name = $validatedData['name'];
        $category->slug = Str::slug($validatedData['name']);
        $category->update();

        Log::channel('journal')->info('The Category'.'  '.$request->input('name').' updated successfully');

        return redirect()->route('categories.index')
                            ->with('success', 'Category updated successfully');
    }

    
}
