<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\T03Pool;
use App\Flashboard;
use App\PoolView;
use Auth;

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
        Schema::defaultStringLength(191);

        //window admin pool data
        View::composer('layouts.windowadmin.load-pool', function ($view) {
          $view->with('onPool', T03Pool::all()
              ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
              ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number)
              ->take(4));
        });

        //flashboard data
        View::composer('Flashboard-data', function ($view) {
          $view->with('windows', PoolView::all()
            ->where('queue_station_number', '=', Auth::guard('flashboard')->user()->record_station_number)
            ->sortBy('queue_window_number'));
        });
    }
}
