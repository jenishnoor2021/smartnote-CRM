<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function login(Request $req)
    {
        $user = User::where(['username' => $req->username])->first();
        if (!$user || !Hash::check($req->password, $user->password)) {
            return redirect()->back()->with('alert', 'Username or password does not matched');
        } else {
            if (!$user->is_active) {
                return redirect()->back()->with('alert', 'Your account has been deactivated. Please contact admin.');
            }
            Auth::loginUsingId($user->id);
            $req->session()->put('user', $user);
            return redirect('/admin/dashboard');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }

    public function dashboard()
    {
        return view('admin.index');
    }

    public function profiledit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.profile.edit', compact('user'));
    }

    public function profileUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $sessionUser = Session::get('user');

        if (!$sessionUser) {
            return redirect()->back()->with('error', 'User session not found.');
        }

        $user = User::find($sessionUser->id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Check current password
        if (!(Hash::check($request->get('current_password'), $user->password))) {
            return redirect()->back()->with("error", "Your current password does not matches with the password you provided. Please try again.");
        }

        if (strcmp($request->get('current_password'), $request->get('new_password')) == 0) {
            return redirect()->back()->with("error", "New Password cannot be same as your current password. Please choose a different password.");
        }

        // Change Password
        $user->password = bcrypt($request->get('new_password'));
        $user->save();

        // Update session user
        Session::put('user', $user);

        return redirect()->back()->with("success", "Password changed successfully !");
    }
}
