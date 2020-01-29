<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EditProfileController extends Controller
{
    protected $state = ["Amman", "Ajlun", "Al Aqabah", "Al Balqa'", "Al Karak", "Al Mafraq", "At Tafilah", "Az Zarqa'", "Irbid", "Jarash", "Ma'an", "Madaba"];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        $user = Auth::user();

        return view('auth.EditProfile', ["user" => Auth::user(), "states" => $this->state]);

    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $attributes = request()->validate([
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/^[0-9+]*$/', 'max:15'],
            'country' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'image' => 'nullable|image|max:5000'
        ]);
        if (!array_key_exists("image",$attributes))
        {
            $attributes['image'] = $user->image;
        }

        if ($request->hasFile('image')) {
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $attributes['image'] = uniqid() . '.' . $ext;
            $image->storeAs('public/storage/users', $attributes['image']);
            //delete the previous image.
            Storage::delete("public/storage/users/$user->image");
        }

            if($user->email == $attributes["email"] &&
                $user->name == $attributes["name"] &&
                $user->phone == $attributes["phone"] &&
                $user->country == $attributes["country"] &&
                $user->state == $attributes["state"] &&
                $user->address == $attributes["address"] &&
                $user->image == $attributes["image"]){
                return redirect()->back()->withErrors(array('error' => 'Nothing change !!'));

            };
        $user->update($attributes);
        return redirect()->back()->with("message", "Your profile successfully Edit");

    }
}

