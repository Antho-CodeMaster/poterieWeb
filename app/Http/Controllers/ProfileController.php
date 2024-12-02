<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use App\Models\Artiste;
use App\Models\Question_securite;
use App\Models\Reseau;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        // Check if the authenticated user is an artiste
        $artiste = Artiste::where('id_user', $request->user()->id)->first();

        $twoFactor =  new TwoFactorController();
        $qrCode = $twoFactor->getQr();
        $security_questions = Question_securite::all();

        return view('profile.edit', [
            'user' => $request->user(),
            'artiste' => $artiste,
            'qrCode' => $qrCode,
            'security_questions' => $security_questions
        ]);
    }

    /**
     * Display the user's facturation form.
     */
    public function facturation(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

        $customer = null;
        $art = Artiste::where('id_user', Auth::id())->first();

        if (Auth::user()->stripe_id != null)
            $customer = \Stripe\Customer::retrieve(Auth::user()->stripe_id);

        // Informations pour le formulaire d'abonnement

        $sub_info = null;
        $subbed = false;
        $was_subbed = false;
        if ($art != null && !$art->is_etudiant)
            if ($art->subscribed())
                $subbed = true;
            else
                $was_subbed = true;

        if ($subbed || $was_subbed) {
            $info = \Stripe\Subscription::all([
                'customer' => Auth::user()->stripe_id,
                'status' => 'all'
            ]);
            if (!empty($info->data)) {
                $sub_info = $info->data[0];
                $sub_info['debut'] = Carbon::createFromTimestamp($sub_info->created)->locale('fr_FR')->isoFormat('dddd [le] D MMMM YYYY');
                $sub_info['debut_periode'] = Carbon::createFromTimestamp($sub_info->current_period_start)->locale('fr_FR')->isoFormat('dddd [le] D MMMM YYYY');
                $sub_info['fin_periode'] = Carbon::createFromTimestamp($sub_info->current_period_end)->locale('fr_FR')->isoFormat('dddd [le] D MMMM YYYY');
            }
            else
            {
                $subbed = false;
                $was_subbed = false;
            }
        }

        // Si la méthode de paiement a bel et bien été définie, remplacer tout ancienne méthode de paiement par la nouvelle.
        if (request()->query('success') === 'true') {

            // Retrieve existing payment methods
            $existingPaymentMethods = \Stripe\PaymentMethod::all([
                'customer' => $customer->id,
                'type' => 'card',
            ]);

            $totalPaymentMethods = count($existingPaymentMethods->data);
            // Replace old payment methods
            for ($i = 0; $i < $totalPaymentMethods; $i++) {
                $paymentMethod = $existingPaymentMethods->data[$i];
                if ($i == 0) {
                    $stripe->customers->update(Auth::user()->stripe_id, ['invoice_settings' => ['default_payment_method' => $paymentMethod->id]]);
                    if ($subbed)
                        $stripe->subscriptions->update(
                            $sub_info['id'],
                            ['default_payment_method' => $paymentMethod->id]
                        );
                } else
                    \Stripe\PaymentMethod::retrieve($paymentMethod->id)->detach();
                // Detach every existing payment method but not the new one
                $paymentMethodToDetach = \Stripe\PaymentMethod::retrieve($paymentMethod->id);

                if ($i !== 0)
                    $paymentMethodToDetach->detach();
            }
            Session::flash('succes', 'Vos informations de facturation ont bel et bien été enregistrées. Veuillez rafraîchir la page pour voir les changements!');
        }

        if(request()->query('successConnect') === 'true'){
            Session::flash('succes', 'Vos informations de virements ont bel et bien été enregistrées. Vous commencerez maintenant à recevoire des paiements pour vos ventes.');
        }

        if ($customer != null)
            $customer->invoice_settings->default_payment_method == null ? $card_info = null : $card_info = \Stripe\PaymentMethod::retrieve($customer->invoice_settings->default_payment_method)->card;
        else
            $card_info = null;


        return view('profile.facturation', [
            'user' => $request->user(),
            'subbed' => $subbed,
            'was_subbed' => $was_subbed,
            'artiste' => $art,
            'card' => $card_info,
            'subscription' => $sub_info
        ]);
    }

    public function stripe_methodePaiement_form()
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
        $allReseaux = Reseau::all();

        if ($artiste) {
            $reseaux = $artiste->reseaux;

            return view('profile.personnaliser', [
                'user' => $request->user(),
                'artiste' => $artiste,
                'reseaux' => $reseaux,
                'allReseaux' => $allReseaux,
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

    public function updateQuestion(Request $request)
    {
        $validated = $request->validateWithBag('updateQuestion', [
            'question' => ['required'],
            'reponse' => ['required', 'confirmed'],
        ]);

        $request->user()->id_question_securite = $validated['question'];
        $request->user()->reponse_question = Hash::make($validated['reponse']);

        if($request->user()->save())
            Session::flash('succes_question', 'La question de sécurité et sa réponse ont été mis à jour.');
        else
            Session::flash('erreur_question', 'Erreur lors de la mise à jour de la question de sécurité. Veuillez réessayer plus tard.');

        return back();
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


    public function creeCompteConnect(){
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $artiste = Artiste::where('id_user',Auth::id())->first();

        if($artiste->stripe_acc == null){
            $account = \Stripe\Account::create([
                'type' => 'express',
                'country' => 'CA',
                'email' => $artiste->user->email,
                'business_type' => 'individual',
                'capabilities' => [
                    'card_payments' => ['requested' => true],
                    'transfers' => ['requested' => true],
                ],
            ]);
        } else{
            $account = \Stripe\Account::update($artiste->stripe_acc);
        }

        $artiste->stripe_acc = $account->id;
        $artiste->save();

        $lienCompte = \Stripe\AccountLink::create([
            'account' => $account->id,
            'refresh_url' => route('connect-refresh'),
            'return_url' => route('profile.facturation') . '?successConnect=true',
            'type' => 'account_onboarding'
        ]);

        return redirect($lienCompte->url);
    }

    public function connectReturn(Request $request){
        return view('profile.stripe-return');
    }

    //Si le lien est expiré et revisité
    public function connectRefresh(Request $request){
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $artiste = Artiste::where('id_user',Auth::id())->first();

        $account = \Stripe\Account::update($artiste->stripe_acc);

        $lienCompte = \Stripe\AccountLink::create([
            'account' => $account->id,
            'refresh_url' => route('connect-refresh'),
            'return_url' => route('connect-return'),
            'type' => 'account_onboarding'
        ]);

        return redirect($lienCompte->url);
    }

    /**
     * Delete the user's card.
     */
    public function destroy_card(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
        $customer = \Stripe\Customer::retrieve(Auth::user()->stripe_id);

        // Retrieve existing payment methods
        $existingPaymentMethods = \Stripe\PaymentMethod::all([
            'customer' => $customer->id,
            'type' => 'card',
        ]);

        $totalPaymentMethods = count($existingPaymentMethods->data);
        // Replace old payment methods
        for ($i = 0; $i < $totalPaymentMethods; $i++) {
            \Stripe\PaymentMethod::retrieve($existingPaymentMethods->data[$i]->id)->detach();
        }
        $stripe->customers->update(Auth::user()->stripe_id, ['invoice_settings' => ['default_payment_method' => null]]);

        Session::flash('succes', 'Vos informations de facturation ont bel et bien été enregistrées!');

        return redirect(route('profile.facturation'));
    }
}
