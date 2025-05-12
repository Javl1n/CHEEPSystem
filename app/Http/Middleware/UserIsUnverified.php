<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserIsUnverified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // dd($user->verification->verified);

        if ($user->role->id !== 1) {
            if($user->verification->verified) {
                return redirect('posts');
            } 
            if ($user->verification->verified === 0) {
                return redirect('deleted');
            }
        }

        return $next($request);
    }
}
