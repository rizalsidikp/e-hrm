<?php

namespace App\Http\Middleware;

use App\Models\Favorite;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Favorites
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth() && auth()->user()){
            $favorites = Favorite::select('user_id', 'label', 'icon', 'url')->where("user_id", auth()->user()->id)->orderBy('id', 'desc')->get()->toArray();
            view()->share('favorites', $favorites);
            return $next($request);
        }
        return $next($request);
    }
}
