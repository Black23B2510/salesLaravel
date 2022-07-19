<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Slide;
class ProductController extends Controller
{
    public function getProducts(){
        $slide = Slide::all();
        $new_product  = Product::where('new', 1)->get();
        $promotion_product = Product::where('new',0)->get();
        $product_type = ProductType::all();
        return view('pages.index', compact('new_product','promotion_product','slide','product_type'));
    }
    public function getProductDetail($id){
        $product = Product::find($id);
        $new_product  = Product::where('new', 1)->take(4)->get(); 
        return view('pages.detail', compact('product','new_product'));
    }
}