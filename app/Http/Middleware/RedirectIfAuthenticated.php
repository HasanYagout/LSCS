<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                switch ($guard) {
                    case 'admin':
                        if (Auth::guard($guard)->check()) {
                            return redirect()->route('admin.dashboard');
                        }
                        break;
                    case 'alumni':
                        if (Auth::guard($guard)->check()) {
                            return redirect()->route('alumni.home');
                        }
                        break;
                    case 'web':
                        if (Auth::guard($guard)->check()) {
                            return redirect()->route('home');
                        }
                        break;
                    default:
                        if (Auth::guard($guard)->check()) {
                            return redirect('home');
                        }
                        break;
                }
            }
        }

        return $next($request);
    }
}
