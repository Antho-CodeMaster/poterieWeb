<?php

namespace App\Http\Controllers;

use App\Models\Abonnement;
use App\Models\Artiste;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AbonnementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $user = Auth::user();

        // Si le user n'a jamais setup de carte, on lui créée un objet "Customer" avec son e-mail
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
            'mode' => 'subscription',
            'customer' => $user->stripe_id,
            'line_items' => [[
                'price' => env("SUBSCRIPTION_PRICE_ID"),
                'quantity' => 1,
            ]],
            'success_url' => route('demarrer-abonnement'),
            'cancel_url' => url()->previous(),
            'locale' => 'fr-CA'
        ]);

        return redirect($checkoutSession->url);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $artiste = Artiste::where('id_user', Auth::id())->first();
        if ($artiste->subscribed()) {
            // MAJ de la méthode de paiement
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
            $info = \Stripe\Subscription::all([
                'customer' => Auth::user()->stripe_id,
                'status' => 'active'
                ]);
            $pm = $info->data[0]->default_payment_method;
            $stripe->customers->update(Auth::user()->stripe_id, ['invoice_settings' => ['default_payment_method' => $pm]]);

            // Artiste devient actif
            $artiste->actif = true;
            $artiste->save();
            return redirect(route('kiosque', ['idUser' => Auth::id()]) . '?firstaccess=true');
        } else
            return url()->previous();
    }

    /**
     * Display the specified resource.
     */
    public function show(Abonnement $abonnement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Abonnement $abonnement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Abonnement $abonnement)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Abonnement $abonnement)
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $user = Auth::user();

        if ($user->stripe_id == null)
            return back()->withErrors(["error" => "Erreur lors de l'annulation de votre abonnement. Veuillez contacter l'administration via la page \"Nous contacter\"."]);

        // Retrieve all active subscriptions for this customer
        $subscriptions = \Stripe\Subscription::all([
            'customer' => $user->stripe_id,
            'status' => 'active',
        ]);

        // Loop through each subscription and cancel them
        foreach ($subscriptions->data as $subscription)
            foreach ($subscription->items->data as $item)
                if ($item->price->product === env("SUBSCRIPTION_PRODUCT_ID")) {
                    \Stripe\Subscription::update($subscription->id, [
                        'cancel_at_period_end' => true, // Set to cancel at the end of the billing period
                    ]);
                    Session::flash('succes', "Votre abonnement a été annulé.");
                    return back();
                }

        return back()->withErrors(["error" => "Erreur lors de l'annulation de votre abonnement. Veuillez contacter l'administration via la page \"Nous contacter\"."]);
    }
}
