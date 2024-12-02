<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->first();
            $existingUser = User::where('email', $user->email)->first();

            if ($finduser) {
                Auth::login($finduser);
                return redirect()->intended('/');
            } else if ($existingUser) {
                // Add google_id to the existing user
                $existingUser->update(['google_id' => $user->id]);

                Auth::login($existingUser);
                return redirect()->intended('/');
            } else {
                $newUser = User::factory()->create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'password' => Hash::make('password'),
                ]);

                Auth::login($newUser);
                return redirect()->intended('/');
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
