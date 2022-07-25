<?php

namespace App\Providers;
use App\Models\ProductType;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\Paginator;
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
        Paginator::useBootstrap();
        view()->composer('layout.header', function ($view) {                           
            $loai_sp = ProductType::all();                          
            $view->with('loai_sp', $loai_sp);               
        });
        view()->composer(['pages.index','pages.product_type'], function ($view) {  
            $top_products  = Product::where('new', 0)->cursorPaginate(8);                                                
            $view->with('top_products', $top_products);               
        });
        view()->composer(['layout.header','pages.checkout'],function ($view){
            if(Session('cart')){
                $oldCart = Session::get('cart');
                $cart= new Cart($oldCart);
                $view->with(['cart'=>Session::get('cart'),'productsCart'=>$cart->items,
                'totalPrice'=>$cart->totalPrice,'totalQty'=>$cart->totalQty]);
            }
        });
    }
}