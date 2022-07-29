<?php

namespace App\Providers;
use App\Models\ProductType;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Wishlist;
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
        
        // ------------------------WISHLIST------------------------
        view()->composer('layout.header', function ($view) {
            if (Session('user')) {
                $user = Session::get('user');
                $wishlists = Wishlist::where('id_user', $user->id)->get();
                $sumWishlist = 0;
                $totalWishlist = 0;
                $productsInWishlist = [];
                if (isset($wishlists)) {
                    foreach ($wishlists as $item) {
                        $sumWishlist += $item->quantity;
                        $product = Product::find($item->id_product);
                        $productsInWishlist[] = $product;
                        if ($product->promotion_price == 0) {
                            $totalWishlist += (intval($item->quantity) * intval($product->unit_price));
                        } else {
                            $totalWishlist += (intval($item->quantity) * intval($product->promotion_price));
                        }
                    }
                }

                $view->with(['user' => $user, 'wishlists' => $wishlists, 'sumWishlist' => $sumWishlist, 'productsInWishlist' => $productsInWishlist, 'totalWishlist' => $totalWishlist]);
            }
        });
    }
}