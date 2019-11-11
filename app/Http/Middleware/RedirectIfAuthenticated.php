<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
          switch ($guard) {
        case 'queue_admin':
          if (Auth::guard($guard)->check()) {
            return redirect()->route('queueadminhome');
          }

        case 'station_admin':
          if (Auth::guard($guard)->check()) {
            return redirect()->route('stationadminhome');
          }

        case 'window_admin':
          if (Auth::guard($guard)->check()) {
            return redirect()->route('windowadminhome');
          }
          break;

        case 'flashboard':
          if (Auth::guard($guard)->check()) {
            return redirect()->route('flashboardhome');
          }
          break;

        case 'kiosk':
          if (Auth::guard($guard)->check()) {
            return redirect()->route('kioskhome');
          }
          break;


        default:
          if (Auth::guard($guard)->check()) {
            return redirect()->route('superadminhome');
          }
          break;
      }

        return $next($request);
    }
}
