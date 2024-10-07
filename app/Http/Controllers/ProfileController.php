<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Artiste;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        // Check if the authenticated user is an artiste
        $artiste = Artiste::where('id_user', $request->user()->id)->first();

        return view('profile.edit', [
            'user' => $request->user(),
            'artiste' => $artiste,
        ]);
    }

        /**
     * Display the user's facturation form.
     */
    public function facturation(Request $request): View
    {
        return view('profile.facturation', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the user's accessibility (blur) information.
     */
    public function updateBlur(Request $request): RedirectResponse
    {
        $blurEnabled = ($request['blurValue'] === 'on' | 0 ? 0 : 1);

        $request->user()->contenu_sensible = $blurEnabled;

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'blur-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        $user->active = 0;

        Auth::logout();

        #$user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
