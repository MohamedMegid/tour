<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Lang;

class AdminMiddleware
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
        
        if(Auth::check()) {
            if (!$request->user()->user_role || $request->user()->user_role->role_id != '3'){
                abort('403', 'Unauthorized action.');
               // return redirect('/');
              }
         }
        else
        {
            return redirect('/admin/login');
        }

        return $next($request);
    }
}
