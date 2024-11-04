<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
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
    public function facturation(Request $request)
    {
        // Si la méthode de paiement a bel et bien été définie, remplacer tout ancienne méthode de paiement par la nouvelle.
        if (request()->query('success') === 'true') {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

            // Retrieve the customer
            $customer = \Stripe\Customer::retrieve(Auth::user()->stripe_id);

            // Retrieve existing payment methods
            $existingPaymentMethods = \Stripe\PaymentMethod::all([
                'customer' => $customer->id,
                'type' => 'card',
            ]);

            $totalPaymentMethods = count($existingPaymentMethods->data);
            // Replace old payment methods
            for ($i = 0; $i < $totalPaymentMethods; $i++) {
                $paymentMethod = $existingPaymentMethods->data[$i];
                // Detach every existing payment method but not the new one
                $paymentMethodToDetach = \Stripe\PaymentMethod::retrieve($paymentMethod->id);

                if($i !== 0)
                    $paymentMethodToDetach->detach();
            }
            Session::flash('succes', 'Vos informations de facturation ont bel et bien été enregistrées!');
        }

        $art = Artiste::where('id_user', Auth::id())->first();
        $subbed = false;
        if($art != null)
            $subbed = $art->subscribed();

        return view('profile.facturation', [
            'user' => $request->user(),
            'subbed' => $subbed,
            'artiste' => $art,
        ]);
    }

    public function stripe_facturation_form()
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $user = Auth::user();

        // Si c'est la première fois que le user setup sa carte
        if ($user->stripe_id == null) {
            $customer = \Stripe\Customer::create([
                'email' => Auth::user()->email,
                'name' => Auth::user()->name,
            ]);

            $user->stripe_id = $customer->id;
            $user->save();
        }

        $checkoutSession = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'mode' => 'setup', // Specifies this session is only for setting up a payment method
            'customer' => Auth::user()->stripe_id, // Attach this to an existing Stripe Customer
            'success_url' => route('profile.facturation') . '?success=true', // Redirect on success
            'cancel_url' => route('profile.facturation'),   // Redirect on cancellation
            'locale' => 'fr-CA',
        ]);

        // Redirect the customer to the Stripe Checkout page
        return redirect($checkoutSession->url);
    }


    /**
     * Display the user's facturation form.
     */
    public function personnaliser(Request $request): View
    {
        $artiste = Artiste::where('id_user', $request->user()->id)->first();

        if ($artiste) {
            return view('profile.personnaliser', [
                'user' => $request->user(),
                'artiste' => $artiste,
            ]);
        } else {
            return view('profile.edit', [
                'user' => $request->user(),
                'artiste' => $artiste,
            ]);
        }
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
