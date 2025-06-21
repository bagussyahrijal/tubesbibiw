<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FirebaseSession
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('firebase_uid')) {
            return redirect()->route('login');
        }
        return $next($request);
    }
}
