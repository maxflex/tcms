<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;

class UserLogin
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
        if (! User::loggedIn()) {
            $wallpaper = (object)[
                'image_url' => 'img/background/1.jpg'
            ];
            return view('login.login', compact('wallpaper'));
        }
        view()->share('user', User::fromSession());
        return $next($request);
    }
}
