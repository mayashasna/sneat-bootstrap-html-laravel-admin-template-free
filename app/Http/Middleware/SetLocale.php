<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // اللغة الافتراضية
        $locale = session('locale', 'ar');

        // ضبط اللغة
        app()->setLocale($locale);

        return $next($request);
    }
}