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
        $this->middleware('admin')->except(['show']);
        $this->middleware('auth')->except(['show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
//        $news = News::all()->take(10);//return the top news art
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

//        $this->validate(request(), [
//            'name' => 'required|unique:games',
//            'description' => 'required',
//        ]);
        $attributes = request()->validate([
            'name' => ['required', 'unique:categories', 'min:3'],
            'description' => ['required', 'min:3']
        ]);

        Category::create($attributes);
        session()->flash("message", "{$request->name} category has been created.");
        return redirect()->route('category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
            'description' => ['required', 'min:3']
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
     */
    public function destroy(Category $category)
    {
        $category->delete();
        session()->flash("message", "Category has been successfully Deleted.");
        return redirect()->route('category.index');
    }
}
