<?php

namespace App\Http\Controllers;

use App\News;
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
        $news = News::all();
//        $news = News::all()->take(10);//return the top news art
        return view('pages.news.all_news', compact("news"));
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

//        $this->validate(request(), [
//            'title' => 'required|unique:games',
//            'body' => 'required',
//            'image' => 'required',
//        ]);

        $filename = "no_img_news.jpg";
        if ($request->hasfile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save(public_path('/uploads/news_img/' . $filename));
        }
        News::create([
            'title' => $request->title,
            'body' => $request->body,
            'image' => $filename]);;

        return redirect('/news');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('pages.news.news', ['data' => News::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('pages.news.edit', ['data' => News::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $image = $request->file('image');
        $filename = $image->getClientOriginalName();
        if ( $filename!="no_img_news.jpg"&& $filename!=item::find($id)->get()->image) {//ok here chech the get function
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save(public_path('/uploads/news_img/' . $filename));
        }
        News::find($id)->update([
            'title' => $request->title,
            'body' => $request->body,
            'image' => $filename ]);
        return redirect()->route('news.show', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        News::destroy($id);
        return redirect()->route('item.index');
//        return redirect('News')->with('success', 'Data is successfully deleted');
    }
}
