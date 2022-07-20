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
}