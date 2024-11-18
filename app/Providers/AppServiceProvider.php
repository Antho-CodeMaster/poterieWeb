<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Commande;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {

            $request = app(Request::class);

            if(Auth::check())
            {
                $panier = Commande::where('id_user', Auth::id())->where('is_panier', true)->first();
                $items = $panier ? $panier->transactions : [];
            }
            else
            {
                $cookie = $request->cookie('panier','');
                $items = $cookie ? json_decode($cookie,true) : [];
            }

            $items = $items ? $items : [];

            $basketCount = sizeof($items);

            $view->with('basketCount', $basketCount);
        });
    }
}
