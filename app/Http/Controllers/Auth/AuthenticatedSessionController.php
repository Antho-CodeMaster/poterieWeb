<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Artiste;
use PHPUnit\Metadata\DisableReturnValueGenerationForTestDoubles;
use PragmaRX\Google2FA\Google2FA as Google2FAGoogle2FA;
use PragmaRX\Google2FALaravel\Google2FA;

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

            $art = Artiste::where('id_user', Auth::id())->first();

            if ($art != null)
                $art->validate();


            if($user->uses_two_factor_auth){

                $google2fa = new Google2FAGoogle2FA();
                if($request->session()->has('2fa:auth:passed')){
                    $request->session()->forget('2fa:auth:passed');
                }



                //return redirect()->route('decouverte')->with('show_2fa_modal', true);


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
