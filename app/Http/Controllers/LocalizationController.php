<?php

namespace App\Http\Controllers;

use App;

class LocalizationController extends Controller
{
    public function index($locale, $route)
    {
        App::setLocale($locale);
        session()->put('locale', $locale);
        return redirect()->to($locale . '/admin');
    }
}
