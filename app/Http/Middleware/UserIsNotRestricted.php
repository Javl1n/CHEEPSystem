<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class UserIsNotRestricted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user->role->id !== 1) {
            if($user->restricted_until && Carbon::parse($user->restricted_until)->greaterThan(now())) {
                return redirect('restricted');
            }
        }

        return $next($request);
    }
}
