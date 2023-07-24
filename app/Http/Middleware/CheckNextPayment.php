<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckNextPayment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        $SA = $user->hasRole('SUPER-ADMIN');
        view()->share('next_payment', false);
        $request->attributes->set('next_payment', false);

        if ($SA) return $next($request);

        if ($user->next_payment) {
            if ($user->next_payment <= date('Y-m-d')) {
                view()->share('next_payment', true);
                $request->attributes->set('next_payment', true);

                return $next($request);
            } else {
                return $next($request);
            }
        } else {
            return $next($request);
        }
    }
}
