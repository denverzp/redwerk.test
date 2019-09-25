<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {


        //global data
        view()->composer('*', function($view){

            //to JavaScipt app data
            $user  = [];

            if(Auth::check()){
                $is_user = Auth::user();

                if($is_user !== null){
                    $needed_fields = ['id', 'name', 'email', 'phone'];
                    foreach ($needed_fields as $fieldname) {
                        if(isset($is_user->$fieldname)){
                            // tariffs
                            if($fieldname === 'tariffs'){
                                $tariffs = $is_user->tariffs->toArray();
                                array_walk($tariffs, function($tariff) use(&$user) {
                                    if ($tariff['type_id'] === 1) {
                                        $user['tariff_sms'] = $tariff['name'];
                                    } elseif ($tariff['type_id'] === 2) {
                                        $user['tariff_viber'] = $tariff['name'];
                                    }
                                });
                            } else {
                                $user[$fieldname] = $is_user->$fieldname;
                            }
                        }
                    }
                }
            }

            $view->with('js_data', collect([
                'user' => $user
            ]));
        });
    }
}
