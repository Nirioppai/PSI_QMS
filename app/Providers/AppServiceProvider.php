<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\T03Pool;
use App\T03Priority;
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

            // Priority Counters
            $PriorityCount = T03Priority::all()
                ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number)
                ->count();
            $NonPriorityCount = T03Pool::all()
                ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number)
                ->count();
            $OnWindowCheck = PoolView::all()
                ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number)
                ->where('queue_window_number', '=', Auth::guard('window_admin')->user()->window_number)
                ->where('queue_action', '=', '1')
                ->pluck('queue_priority')
                ->first();
            $priorityCheck = Auth::guard('window_admin')->user()->is_priority_window;

            $PriorityPools = T03Priority::all()
                ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number)
                ->take(4);

            $NonPriorityPools = T03Pool::all()
                ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number)
                ->take(4);

            if($priorityCheck == 'Yes' || $NonPriorityCount == 0 )
            {
                if($OnWindowCheck == 0)
                {
                    if($PriorityCount == 0)
                    {
                        $view->with('onPool', $NonPriorityPools);
                    }
                    else
                    {
                        $view->with('onPool', $PriorityPools);
                    }
                }
            else
            {

                if($PriorityCount > 0)
                {
                    $view->with('onPool', $PriorityPools);
                }
                else
                {

                    $view->with('onPool', $NonPriorityPools);
                }
            }

        }

        if($priorityCheck == 'No' || $PriorityCount == 0)
        {
            $view->with('onPool', $NonPriorityPools);
        }

        });

        //flashboard data
        View::composer('Flashboard-data', function ($view) {
          $view->with('windows', PoolView::all()
            ->where('queue_station_number', '=', Auth::guard('flashboard')->user()->record_station_number)
            ->sortBy('queue_window_number'));
        });
    }
}
