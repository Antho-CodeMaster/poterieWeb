<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FAQRCode\Google2FA;
use App\Models\User;
use Illuminate\Validation\ValidationException;

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Writer;

class TwoFactorController extends Controller
{
    public function show(Request $request){
        $google2fa = new Google2FA();
        $user = User::find(Auth::id());

        if($user->google2fa_secret == null){
            $key = $google2fa->generateSecretKey();

            $user->google2fa_secret = $key;
            $user->uses_two_factor_auth = true;
            $user->save();
        }



        $renderer = new ImageRenderer(
            new \BaconQrCode\Renderer\RendererStyle\RendererStyle(256),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);

        // Generate QR Code
        $qrCode = $writer->writeString(
            $google2fa->getQRCodeUrl(
                '@Terracium', // Issuer (App Name)
                $user->email,  // User's email
                $user->google2fa_secret // Secret key
            )
        );

        return view('f2a-test')->with([
            'qrCode' => $qrCode
        ]);
    }

    public function verify(Request $request){
        $request->validate([
            'one_time_password' => 'required|string'
        ]);


        if(!Auth::check()){
            return redirect('/');
        }

        $user = User::find(Auth::id());

        if(!$user || !$user->uses_two_factor_auth){
            return redirect('/');
        }

        $google2fa = new Google2FA();
        $otp_secret = $user->google2fa_secret;

        if($google2fa->verify($request->one_time_password ,$otp_secret)){
            $request->session()->put('2fa:auth:passed', true);

            return redirect()->intended('/');
        }

        $request->session()->put('2fa:auth:passed', false);
        return redirect()->route('login')->withErrors([
            'password' => __('Authentification multifactorielle échoué'),
        ]);
    }

    public function create(Request $request){
        $request->validate([
            'one_time_password' => 'required|string'
        ]);

        $user = User::find(Auth::id());


        $google2fa = new Google2FA();
        $otp_secret = $user->google2fa_secret;

        if($google2fa->verify($request->one_time_password ,$otp_secret)){
            $user->uses_two_factor_auth = true;
            $user->save();

            $request->session()->put('2fa:auth:passed', true);

            return redirect()->route('profile.edit')->with('status', '2fa-updated');
        }

        return back()->withErrors(['one_time_password' => 'Code incorrect, veuillez réessayer.'])->with('status', '2fa-failed');
    }

    public function getQr(){
        $google2fa = new Google2FA();
        $user = User::find(Auth::id());

        if($user->google2fa_secret == null){
            $key = $google2fa->generateSecretKey();

            $user->google2fa_secret = $key;
            $user->save();
        }



        $renderer = new ImageRenderer(
            new \BaconQrCode\Renderer\RendererStyle\RendererStyle(256),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);

        // Generate QR Code
        $qrCode = $writer->writeString(
            $google2fa->getQRCodeUrl(
                '@Terracium', // Issuer (App Name)
                $user->email,  // User's email
                $user->google2fa_secret // Secret key
            )
        );

        return $qrCode;
    }

    public function destroy(Request $request){
        $user = User::find(Auth::id());

        $user->uses_two_factor_auth = false;
        $user->google2fa_secret = null;
        $user->save();

        $request->session()->forget('2fa:auth:passed');

        return redirect()->route('profile.edit')->with('status', '2fa-updated');
    }
}
