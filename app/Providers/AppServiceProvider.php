<?php

namespace App\Providers;

use App\Models\ConfigurationTable;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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

        $configurations = ConfigurationTable::select(['screen_name','route','icon_class','model_name'])->orderBy('item_index')->get();
        View::share(['configurations'=>$configurations]);
    }
}
