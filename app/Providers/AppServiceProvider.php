<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Drugs\Terapie;
use App\Models\CareProviders\CppPaziente;
use View;
use Auth;
use Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Passa ad ogni pagina il riferimento
        // all'oggetto dell'utente loggato.
        view()->composer('*', function($view) {
            $view->with('current_user', auth()->user());
        });


        view()->composer('*', function($view) {

          if(Auth::user() != NULL){
            $id = Auth::user()->isImpersonating() ? Session::get('impersonate') : Auth::id();
            $terapie = Terapie::where('id_paziente', $id)->get();
            $confidenzialita_auth = Auth::user()->isImpersonating() ? CppPaziente::where('id_cpp', Session::get('beforeImpersonate'))->where('id_paziente', $id)->first()->assegnazione_confidenzialita : 0;
            $view->with('terapie', $terapie)->with('confidenzialita_auth', $confidenzialita_auth);
          }

        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
        //
    }
}
