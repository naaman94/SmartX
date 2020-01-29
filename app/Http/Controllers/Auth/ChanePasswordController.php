<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChanePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function editPassword()
    {
        return view('auth.passwords.changePassword');
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();
        if (!(Hash::check($request->current_password, $user->password))) {
            session()->flash("error", " Your current password does not matches with the password you provided. Please try again.");
            return redirect()->back();
        }
        if (strcmp($request->current_password, $request->new_password) == 0) {
            session()->flash("error", "New Password cannot be same as your current password. Please choose a different password.");
            return redirect()->back();
        }
        $validation = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);
        $user->password = bcrypt($request->new_password);
        $user->save();
        return redirect()->back()->with("message", "Password changed successfully !");
    }
}
