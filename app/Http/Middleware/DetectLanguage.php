<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DetectLanguage
{
    const LOCALES = ['en', 'es'];

    public function handle(Request $request, Closure $next)
    {
        $languages = $request->getLanguages();
        if (!empty($languages)) {
            foreach ($languages as $lang) {
                $langToSearch = str_replace('_', '-', $lang);
                if (in_array($langToSearch, self::LOCALES)) {
                    app('config')->set('app.locale', $langToSearch);
                    break;
                }
            }
        }
        return $next($request);
    }
}
