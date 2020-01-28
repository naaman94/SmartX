<?php

namespace App\Http\Controllers;

use App\Category;
use App\Item;
use Illuminate\Validation\Rule;
use Image;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('created_at', 'DESC')->paginate(20);
        return view('pages.category.all_categories', compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        $attributes = request()->validate([
            'name' => ['required', 'unique:categories', 'min:3'],
            'description' => ['string', 'nullable']

        ]);

        Category::create($attributes);
        session()->flash("message", "{$request->name} category has been created.");
        return redirect()->route('category.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
         return view('pages.category.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $attributes = request()->validate([
            'name' => ['required', Rule::unique('categories')->ignore($category->id), 'min:3'],
            'description' => ['string', 'nullable']

        ]);
        $category->update($attributes);
        session()->flash("message", "{$request->name} category has been successfully Edit.");

        return redirect()->route('category.index');//no it will redirect to edit with same id
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        $category->delete();
        session()->flash("message", "Category has been successfully Deleted.");
        return redirect()->route('category.index');
    }
}
