<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Config;
use Session;
use Illuminate\Http\Request;

class localizationWeb
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Make sure current locale exists.
        $locale = $request->segment(1);

        if (!array_key_exists($locale, app()->config->get('app.locales'))) {
            $segments = $request->segments();
            $segments[0] = app()->config->get('app.fallback_locale');

            return redirect()->to(implode('/', $segments));
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
