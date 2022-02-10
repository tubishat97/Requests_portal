<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\Route;

class LocalizationController extends Controller
{
    public function index($locale, $route)
    {
        App::setLocale($locale);
        session()->put('locale', $locale);

        if (session()->get('locale') == 'ar') {
            $routeAfterLocale = str_replace("en", $locale, route($route));
        } else {
            $routeAfterLocale = str_replace("ar", $locale, route($route));
        }

        return redirect()->to($routeAfterLocale);
    }
}
