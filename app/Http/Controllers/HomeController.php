<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return redirect('admin/');
    }

    public function dashboard(Request $request)
    {
        return view('dashboard');
    }
}
