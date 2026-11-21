<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckUserSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if (!$request->session()->exists('user')) {
            return redirect('/');
        }

        if (!(Session::has('user'))) {
            return redirect('/');
        }

        if (!Auth::guard()->check()) {
            return redirect('/');
        }

        if (!Auth::user()->is_active) {
            Auth::logout();
            if ($request->hasSession()) {
                $request->session()->flush();
            }
            return redirect('/')->with('alert', 'Your account has been deactivated. Please contact admin.');
        }

        return $next($request);
    }

}
