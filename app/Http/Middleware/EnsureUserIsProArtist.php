<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Artiste;
use App\Models\Moderateur;

class EnsureUserIsProArtist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $artiste = Artiste::where('id_user', '=', Auth::id())->first();

        if($artiste == null)
            return redirect('/');
        if ($artiste->is_etudiant == 1)
            return redirect('/');

        return $next($request);
    }
}
