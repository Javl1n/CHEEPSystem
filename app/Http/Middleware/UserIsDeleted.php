<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserIsDeleted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user->verification->verified === null) {
            return redirect(route('unverified'));
        }
 
        if ($user->verification->verified === null) {
            return redirect(route('posts.index'));
        }

        if ($user->verification->notified) {
            Auth::guard('web')->logout();

            Session::invalidate();
            Session::regenerateToken();

            $user->delete();

            return redirect(route('login'));
        }

        $user->verification->update([
            'notified' => true
        ]);

        return $next($request);
    }
}
