<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function profile(Request $request)
    {
        $user = Auth::user();
        return view('admin.users.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {

        try {
            $user = Auth::user()->profile;

            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->save();

            if ($request->has('current_password') && $request->current_password) {
                $passwordRules = [
                    'current_password' => 'required',
                    'password' => 'required|min:6|confirmed'
                ];
                $request->validate($passwordRules);

                if (Hash::check($request->current_password, $user->password)) {
                    $user->fill(['password' => Hash::make($request->password)])->save();
                } else {
                    return redirect()->back()->with('error', 'You entered a worng current password !');
                }
            }

            return redirect()->route('admin.profile')->with('success', __('system-messages.update'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }
}
