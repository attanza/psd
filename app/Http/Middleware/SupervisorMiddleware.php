<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;

class SupervisorMiddleware
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
        if (Auth::check()) {
            $role = Auth::user()->getRole();
            if ($role === 'supervisor') {
                return $next($request);
            } else {
                if ($request->ajax()) {
                    return response()->json(['msg' => 'Request not allowed'], 400);
                }
                Session::flash('error', 'Request not allowed');
                return redirect()->back();
            }
        } else {
            if ($request->ajax()) {
                return response()->json(['msg' => 'Request not allowed'], 400);
            }
            Session::flash('error', 'Request not allowed');
            return redirect()->back();
        }
    }
}
