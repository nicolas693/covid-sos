<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Roles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$tipo_usuario)
    {
        $user = Auth::user();
        if($user->user_type==$tipo_usuario){
            return $next($request);
        }else{
            return response()->view('errors/503');
        }
    }
}
