<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TwoFactorAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = User::find(Auth::id());
            // Check if 2FA has been passed
            if($user->uses_two_factor_auth){
                if (!($request->session()->has('2fa:auth:passed') && $request->session()->get('2fa:auth:passed'))) {
                    session()->flash('show_2fa_modal', true);
                    return redirect()->route('decouverte'); // Redirect to 2FA prompt
                }
            }
        }
        return $next($request);
    }
}
