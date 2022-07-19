<?php

namespace App\Providers;
use App\Models\ProductType;
use App\Models\Product;

use Illuminate\Support\ServiceProvider;

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
        view()->composer('layout.header', function ($view) {                           
            $loai_sp = ProductType::all();                          
            $view->with('loai_sp', $loai_sp);               
        });
        // view()->composer(['pages.index','pages.detail'], function ($view) {  
        //     $new_product  = Product::where('new', 1)->get(4);                                                
        //     $view->with('new_product', $new_product);               
        // });
    }
}