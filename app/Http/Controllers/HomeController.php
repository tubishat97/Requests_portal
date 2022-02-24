<?php

namespace App\Http\Controllers;
class HomeController extends Controller
{
    public function dashboard()
    {
        return redirect(route('admin.request', 'open'));
    }
}
