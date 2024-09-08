<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isOwnerMiddleWarw
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    { 
        $task = $request->route('task');

       if (Auth::id() == $task->assigned_to)
       {
        return $next($request);
       }else{
        return response()->json('this task is not assigned for you');
       }
    }
}
