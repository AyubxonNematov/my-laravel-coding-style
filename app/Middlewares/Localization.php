<?php

namespace App\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the accepted languages from the request header
        $acceptedLanguages = $request->header('Accept-Language', config('locale'));

        // Parse the accepted languages and set the locale
        $locales = explode(',', $acceptedLanguages);
        foreach ($locales as $locale) {
            $locale = trim($locale);
            if (in_array($locale, config('app.supported_locales'))) {
                app()->setLocale($locale);
                break;
            }
        }

        return $next($request);
    }
}
