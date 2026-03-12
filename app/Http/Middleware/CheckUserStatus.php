<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {

            if (Auth::user()->status == 'suspended') {

                Auth::logout();

                return redirect('/login')->with('invalid','Your account has been suspended. Contact Head of School for Help.');
            }
        }
        return $next($request);
    }
}