<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerSupport;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }
}
