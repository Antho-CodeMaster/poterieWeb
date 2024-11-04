<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Artiste;
use App\Models\Moderateur;

class EnsureUserCanBecomeArtist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $artiste = Artiste::where('id_user', '=', Auth::id())->first();
        $admin = Moderateur::where('id_user', '=', Auth::id())->first();
        if ($artiste == null && $admin == null)
            return $next($request);

        return redirect('/');
    }
}
