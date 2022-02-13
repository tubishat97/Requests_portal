<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use stdClass;

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

        try {
            $response = crmCall(crmLoginParams($request->username, $request->password), 'login');

            $user = new stdClass();
            $user->crm_user_id = $response->name_value_list->user_id->value;
            $user->name = $response->name_value_list->user_name->value;
            $user->user_name = $response->name_value_list->user_name->value;
            $user->session_id = $response->id;

            if ($user && $user->crm_user_id) {
                putAuthSessions($user);
            }
            
        } catch (\Exception $e) {
            forgetAuthSessions($request);

            $errors = [
                'username' => 'username or password is incorrect',
            ];

            return redirect()->back()->withInput($request->only('username', 'remember'))->withErrors($errors);
        }

        return redirect()->intended(route('admin.home'));
    }

    public function logout(Request $request)
    {
        forgetAuthSessions($request);

        return redirect(route('admin.login_form'));
    }
}
