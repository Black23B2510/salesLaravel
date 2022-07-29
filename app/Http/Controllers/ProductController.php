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
use App\Models\Payment;
use App\Models\Comment;
use App\Models\Slide;

class ProductController extends Controller
{
    //Hiển thị sản phẩm và slide trong trang Homepage
    public function getProducts(){
        $slide = Slide::all();
        $new_product  = Product::where('new', 1)->cursorPaginate(4);
        $count_products = Product::where('new', 1)->count();
        $promotion_product = Product::where('new',0)->count();
        $product_type = ProductType::all();
        return view('pages.index', compact('new_product','count_products','promotion_product','slide','product_type'));
    }
    
    //Hiển thị chi tiết của một sản phẩm
    public function getProductDetail(Request $request,$id){
        $product = Product::find($id);
        $new_product  = Product::where('new', 1)->take(4)->get(); 
        $best_seller = Product::where('new', 0)->take(4)->get(); 
        $comments = Comment::where('id_product', $request->id)->get();
        return view('pages.detail', compact('product','new_product','best_seller','comments'));
    }
    
    //Hiển thị các loại sản phẩm theo loại
    public function getProductType($type){
        $all_type = ProductType::all();
        $type_product = Product::where('id_type',$type)->cursorPaginate(6);
        $other_products = Product::where('id_type','<>',$type)->get();
        return view('pages.product_type', compact('all_type','type_product','other_products'));
    }
    
    //Thêm mới một sản phẩm vào giỏ hàng
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

    //Xóa một sản phẩm ở giỏ hàng
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
    
    //Trả về view của trang thanh toán
    public function getCheckout(){
        return view('pages.checkout');
    }

    //Lưu hóa đơn vào DB
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
            Session::put('customer', $customer);
            $bill=new Bill();
            $bill->id_customer=$customer->id;
            $bill->date_order=date('Y-m-d');
            $bill->total=$cart->totalPrice;
            $bill->payment=$request->input('payment_method');
            $bill->note=$request->input('notes');
            $bill->status= 'Đang giao';
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
            return view('vnpay.vnpay-index',compact('cart'));
        }
    }

    public function createPayment(Request $request){
        $cart=Session::get('cart');
        $vnp_TxnRef = $request->transaction_id; //Mã giao dịch. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = $request->order_desc;
        $vnp_Amount = str_replace(',', '', $cart->totalPrice * 100);
        $vnp_Locale = $request->language;
        $vnp_BankCode =$request->bank_code;
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $vnpay_Data = array(
            "vnp_Version" => "2.0.0",
            "vnp_TmnCode" => env('VNP_TMNCODE'),
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_ReturnUrl" => route('vnpayReturn'),
            "vnp_TxnRef" => $vnp_TxnRef,
           
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $vnpay_Data['vnp_BankCode'] = $vnp_BankCode;
        }
        ksort($vnpay_Data);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($vnpay_Data as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . $key . "=" . $value;
            } else {
                $hashdata .= $key . "=" . $value;
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = env('VNP_URL') . "?" . $query;
        if (env('VNP_HASHSECRECT')) {
        // $vnpSecureHash = md5($vnp_HashSecret . $hashdata);
        //$vnpSecureHash = hash('sha256', env('VNP_HASHSECRECT'). $hashdata);
        $vnpSecureHash =   hash_hmac('sha512', $hashdata, env('VNP_HASHSECRECT'));//  
           // $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        //dd($vnp_Url);
        return redirect($vnp_Url);
        die();
    }

    //ham nhan get request tra ve tu vnpay
    public function vnpayReturn(Request $request){ 
        //dd($request->all());
        $vnp_SecureHash = $request->vnp_SecureHash;
        //echo $vnp_SecureHash;
        $vnpay_Data = array();
           foreach ($request->query() as $key => $value) {
               if (substr($key, 0, 4) == "vnp_") {
                   $vnpay_Data[$key] = $value;
               }
           }
        unset($vnpay_Data['vnp_SecureHash']);
        ksort($vnpay_Data);
        $i = 0;
        $hashData = "";
        foreach ($vnpay_Data as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
             }else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }
        $secureHash = hash_hmac('sha512', $hashData, env('VNP_HASHSECRECT'));
        // echo $secureHash;
        if ($secureHash == $vnp_SecureHash) {
            if ($request->query('vnp_ResponseCode') == '00') {
                $cart=Session::get('cart');
                //lay du lieu vnpay tra ve
                $vnpay_Data=$request->all();
                //insert du lieu vao bang payments
                $payment = new Payment();
                $payment->bill_id = $vnpay_Data['vnp_TxnRef'];
                $payment->totalPrice = $vnpay_Data['vnp_Amount'] / 100;
                $payment->content = $vnpay_Data['vnp_OrderInfo'];
                $payment->feedback_code = $vnpay_Data['vnp_ResponseCode'];
                $payment->VNPAY_code = $vnpay_Data['vnp_TransactionNo'];
                $payment->bank_code = $vnpay_Data['vnp_BankCode'];
                $payment->payment_time = $vnpay_Data['vnp_PayDate'];
                $payment->save();
                Session::forget('cart');
                //truyen vnpay_Data vao trang vnpay_return
                return view('vnpay.vnpay-return',compact('vnpay_Data'));
                }
            }
    }

    //View index của trang Admin
    public function getIndexAdmin()
    {
        $products =  Product::paginate(5);
        $allProducts =  Product::all()->count();
        return view('adminPage.adminIndex', compact('products','allProducts'));
    }

    //View Thêm một sản phẩm vào trang Admin
    public function getAdminAdd()
    {
        return view('adminPage.formAdd');
    }
    
    //Lưu sản phẩm mới được thêm vào DB
    public function postAdminAdd(Request $request)
    {
        $product = new Product();
        if ($request->hasFile('inputImage')) {
            $file = $request->file('inputImage');
            $fileName = $file->getClientOriginalName('inputImage');
            $file->move('source/image/product', $fileName);
        }
        $file_name = null;
        if ($request->file('inputImage') != null) {
            $file_name = $request->file('inputImage')->getClientOriginalName();
        }

        $product->name = $request->inputName;
        $product->image = $file_name;
        $product->description = $request->inputDescription;
        $product->unit_price = $request->inputPrice;
        $product->promotion_price = $request->inputPromotionPrice;
        $product->unit = $request->inputUnit;
        $product->new = $request->inputNew;
        $product->id_type = $request->inputType;
        $product->save();
        return $this->getIndexAdmin();
    }

    //Xóa một sản phẩm trong DB
    public function postAdminDelete($id)
    {
        $product =  Product::find($id);
        $product->delete();
        return redirect()->back();
    }
    
    //View Edit sản phẩm
    public function getAdminEdit($id)
    {
        $product =  Product::find($id);
        return view('adminPage.formEdit')->with('product', $product);
    }
    
    //Lưu sự thay đổi của sản phẩm sau khi edit
    public function postAdminEdit(Request $request)
    {
        $id = $request->editId;
        $product = Product::find($id);
        if ($request->hasFile('editImage')) {
            $file = $request->file('editImage');
            $fileName = $file->getClientOriginalName('editImage');
            $file->move('source/image/product', $fileName);
        }

        if ($request->file('editImage') != null) {
            $product->image = $fileName;
        }
        $product->name = $request->editName;
        $product->description = $request->editDescription;
        $product->unit_price = $request->editPrice;
        $product->promotion_price = $request->editPromotionPrice;
        $product->unit = $request->editUnit;
        $product->new = $request->editNew;
        $product->id_type = $request->editType;
        $product->save();
        return redirect()->route('admin');
    }

    //Xem danh sách các đơn hàng 
    public function getBillsManage(){
        $bills = Bill::all();
        return view('adminPage.billsManage',compact('bills'));
    }

    //Người dùng xem đơn hàng của mình
    public function getUserBill(){
        $id = '';
        if(Session::has('customer')){
            $id = Session('customer')->id;
        }
        $bills = Bill::where('id_customer',$id)->get();
        return view('pages.userBills',compact('bills'));
    }

    //Thay đổi status khi bấm vào nút đã nhận được hàng
    public function updateStatusBill($id){
        Bill::where('id_customer',$id)->update(['status'=>'da nhan duoc hang']);
        return redirect()->back();
    }
}