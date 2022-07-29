<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use App\Models\Wishlist;
use App\Models\Cart;


class WishlistController extends Controller
{
    //Thêm một sản phẩm vào Whishlist
    public function AddWishlist($id)
    {
        if (Session::has('user')) {
            if (Product::find($id)) {
                // $qty = 1;
                if (Wishlist::where('id', $id)->where('id_user', Session::get('user')->id)->exists()) {
                    $item = Wishlist::where('id', $id)->where('id_user', Session::get('user')->id)->first();
                    $item->quantity +=1;
                    $item->save();
                } else {
                    $add = [
                        'id_user' => Session::get('user')->id,
                        'id_product' => $id,
                        'quantity'=>1
                    ];
                    Wishlist::create($add);
                }

                echo '<script>alert("Thêm vào wishlist thành công.");window.location.assign("/");</script>';
            } else {
                return '<script>alert("Không tìm thấy sản phẩm này.");window.location.assign("/");</script>';
            }
        } else {
            return '<script>alert("Vui lòng đăng nhập để sử dụng chức năng này.");window.location.assign("/getLogin");</script>';
        }
    }
 
    //Xóa một sản phẩm trong Wishlist
    public function DeleteWishlist($id)
    {
        $item = Wishlist::find($id);
        $item->delete();
        return '<script>alert("Đã xóa sản phẩm khỏi wishlist.");window.location.assign("/");</script>';
    }

    //Mua hàng thông qua Wishlist
    public function OrderWishlist()
    {

        $oldCart = Session('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $user = Session::get('user');
        $wishlists = Wishlist::where('id_user', $user->id)->get();
        $sumWishlist = 0;
        if (isset($wishlists)) {
            foreach ($wishlists as $item) {
                $sumWishlist += $item->quantity;
                $product = Product::find($item->id_product);
                $cart->add($product, $product->id);
            }
        }
        session()->put('cart', $cart);
        return redirect()->route('checkout');
    }
}