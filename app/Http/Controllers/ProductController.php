<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\BillDetail;
use App\Models\Bill;
use App\Models\Slide;
class ProductController extends Controller
{
    public function getProducts(){
        $slide = Slide::all();
        $new_product  = Product::where('new', 1)->cursorPaginate(4);
        $count_products = Product::where('new', 1)->count();
        $promotion_product = Product::where('new',0)->count();
        $product_type = ProductType::all();
        return view('pages.index', compact('new_product','count_products','promotion_product','slide','product_type'));
    }
    public function getProductDetail($id){
        $product = Product::find($id);
        $new_product  = Product::where('new', 1)->take(4)->get(); 
        $best_seller = Product::where('new', 0)->take(4)->get(); 
        return view('pages.detail', compact('product','new_product','best_seller'));
    }
    public function getProductType($type){
        $all_type = ProductType::all();
        $type_product = Product::where('id_type',$type)->cursorPaginate(6);
        $other_products = Product::where('id_type','<>',$type)->get();
        return view('pages.product_type', compact('all_type','type_product','other_products'));
    }
    public function AddtoCart(Request $req, $id){
        if (Session::has('user')) {
            if (Product::find($id)) {
                $product = Product::find($id);
                $oldCart = Session('cart') ? Session::get('cart') : null;
                $cart = new Cart($oldCart);
                $cart->add($product, $id);
                $req->session()->put('cart', $cart);
                return redirect()->back();
            } else {
                return '<script>alert("Không tìm thấy sản phẩm này.");window.location.assign("/");</script>';
            }
        } else {
            return '<script>alert("Vui lòng đăng nhập để sử dụng chức năng này.");window.location.assign("/getLogin");</script>';
        }
    }

    public function getDelItemCart($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        if (count($cart->items) > 0 && Session::has('cart')) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }
        return redirect()->back();
    }
    
    public function getCheckout(){
        return view('pages.checkout');
    }

    public function vnpay(){
        return view('pages.vnpay-index');
    }
    public function postCheckout(Request $request){
        if($request->input('payment_method')!="VNPAY"){
            $cart=Session::get('cart');
            $customer=new Customer();
            $customer->name=$request->input('name');
            $customer->gender=$request->input('gender');
            $customer->email=$request->input('email');
            $customer->address=$request->input('address');
            $customer->phone_number=$request->input('phone');
            $customer->note=$request->input('notes');
            $customer->save();
            $bill=new Bill();
            $bill->id_customer=$customer->id;
            $bill->date_order=date('Y-m-d');
            $bill->total=$cart->totalPrice;
            $bill->payment=$request->input('payment_method');
            $bill->note=$request->input('notes');
            $bill->save();
            foreach($cart->items as $key=>$value)
            {
                $bill_detail=new BillDetail();
                $bill_detail->id_bill=$bill->id;
                $bill_detail->id_product=$key;
                $bill_detail->quantity=$value['qty'];
                $bill_detail->unit_price=$value['price']/$value['qty'];
                $bill_detail->save();
            }
            Session::forget('cart');
            echo '<script>alert("Đặt hàng thành công.");window.location.assign("/");</script>';
            // return redirect()->route('homepage')->with('success','Đặt hàng thành công');
    
        }
        else {//nếu thanh toán là vnpay
            $cart=Session::get('cart');
            return view('/vnpay-index',compact('cart'));
        }
    }
}