<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class ShareVariableViewMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $_profilePicture = $user->profile_picture;
            if (is_null($_profilePicture)) {
                $_profilePicture = false;
            } elseif (!Storage::exists($_profilePicture)) {
                $_profilePicture = false;
            } else {
                $_profilePicture = Storage::url($_profilePicture);
            }
            View::share('_profile_picture', $_profilePicture);
        }
        return $next($request);
    }
}
