<?php

namespace App\Http\Middleware;

use Closure;

class Localization
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
        // Check header request and determine localizaton
        $locale = ($request->hasHeader('Accept-Language')) ? $request->header('Accept-Language') : 'en';

        // check the languages defined is supported
        if (!in_array($locale, app()->config->get('app.supported_languages'))) {
            $locale = 'en';
        }

        // set the local language
        app()->setLocale($locale);

        // continue request
        return $next($request);
    }
}
