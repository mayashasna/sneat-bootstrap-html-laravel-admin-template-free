<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuth
{
 public function handle($request, Closure $next)
{
    $user = Auth::guard('admin')->user();

    // إذا ما في مستخدم أو المستخدم مو من نوع Admin
    if (!$user || !$user instanceof \App\Models\Admin) {
        return redirect()->route('admin.login');
    }

    return $next($request);
}
}
