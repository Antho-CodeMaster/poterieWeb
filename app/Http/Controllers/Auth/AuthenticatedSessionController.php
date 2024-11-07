<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Artiste;
use App\Models\Notification;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
    {
        session()->flash('openLoginModal', 'Vous devez vous connecter pour accéder à cette fonctionnalité');
        return redirect('/');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();

        if ($user->active == 0) {
            Auth::guard('web')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect('/');
        } else {
            // Validation de l'artiste pour terminer un abonnement
            $art = Artiste::where('id_user', Auth::id())->first();
            if ($art != null) {
                if ($art->is_etudiant == 0 && $art->actif == 1 && !$art->subscribed()) {
                    $art->actif = 0;
                    $art->save();

                    // Notifier in-app pour avertir l'artiste qu'il perd ses accès
                    $notif = Notification::create([
                        'id_type' => 6,
                        'id_user' => Auth::id(),
                        'date' => now(),
                        'message' => '',
                        'lien' => route('profile.facturation'),
                        'visible' => 1
                    ]);
                    $notif->save();
                }
            }
            return back();
            #return redirect()->intended(route('decouverte', absolute: false));
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
