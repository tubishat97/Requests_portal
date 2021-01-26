<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required|min:6'
        ]);

        // Attempt to log the user in
        if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password], $request->remember)) {
            return redirect()->intended(route('admin.home'));
        }

        $errors = [
            'username' => 'username or password is incorrect',
        ];
        return redirect()->back()->withInput($request->only('username', 'remember'))->withErrors($errors);
    }

    public function logout(Request $request)
    {
        auth::logout();
        $request->session()->invalidate();
        return redirect(route('admin.login_form'));
    }
}
