<?php

namespace App\Http\Controllers;

use App\Ad;
use App\News;
use Illuminate\Support\Facades\Storage;
use Image;
use Illuminate\Http\Request;


class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->except(['index', 'show']);
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sort_by_arr = ["Time: newly listed", "A to Z", "Z to A"];
        switch (request("sort_by")) {
            case "A to Z":
                $sort = "title";
                $order = "ASC";
                break;
            case "Z to A":
                $sort = "title";
                $order = "DESC";
                break;
            case "Time: newly listed":
            default :
                $sort = "created_at";
                $order = "DESC";
                break;
        }

        $ads = Ad::where("show_in_items", true)->orderBy('created_at', 'DESC')->take(3)->get();
        $news = News::orderBy($sort, $order)->paginate(10);
        return view('pages.news.index', compact(["news","sort_by_arr", "ads"]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.news.create');

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
        $attributes = $this->Validation($request);
        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $attributes['image'] = uniqid() . '.' . $ext;
        $image->storeAs('public/storage/news', $attributes['image']);
        News::create($attributes);
        session()->flash("message", "the article : {$request->title} has been created successfully.");
        return redirect()->route('news.index');


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        $ads = Ad::where("show_in_items", true)->orderBy('created_at', 'DESC')->take(3)->get();
        return view('pages.news.show', ['article' => $news,"ads"=>$ads]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        return view('pages.news.edit', ['article' => $news]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        $attributes = $this->Validation($request);
        $attributes['image'] = $news->image;
        if ($request->hasFile('image')) {
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $attributes['image'] = uniqid() . '.' . $ext;
            $image->storeAs('public/storage/news', $attributes['image']);
            Storage::delete("public/storage/news/$news->image");
        }
        $news->update($attributes);

        return redirect()->route('news.show', ['id' => $news]);
    }

    public function destroy(News $news)
    {
        Storage::delete("public/storage/news/$news->image");
        $news->delete();
        session()->flash("message", "Article has been Deleted successfully.");
        return redirect()->route('news.index');
    }

    public function Validation($request)
    {
        return request()->validate([
            'title' => ['required', "string", 'min:3'],
            'body' => ['required', "string", 'min:3'],
            'image' => $request->input('org_image') ? 'image|max:5000' : 'required|image|max:5000'
        ]);
    }
}
