@extends('layout.master')
@section('content')
<div class="inner-header">
    <div class="container">
        <div class="pull-left">
            <h6 class="inner-title">Sản phẩm</h6>
        </div>
        <div class="pull-right">
            <div class="beta-breadcrumb font-large">
                <a href="/">Home</a> / <span>Sản phẩm</span>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="container">
    <div id="content" class="space-top-none">
        <div class="main-content">
            <div class="space60">&nbsp;</div>
            <div class="row">
                <div class="col-sm-3">
                    <ul class="aside-menu">
                        @foreach($all_type as $type)
                        <li><a href="/product_type/{{$type->id}}">{{$type->name}}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-sm-9">
                    <div class="beta-products-list">
                        @foreach($all_type as $type)
                        @if( $type_product[0]->id_type == $type->id )
                        <h4 style="text-align:center;   font-weight: bold;"> {{$type->name}}</h4>
                        @endif
                        @endforeach
                        <div class="beta-products-details">
                            <p class="pull-left">{{count($type_product)}} styles found</p>
                            <div class="clearfix"></div>
                        </div>
                        <div class="row">
                            @foreach ($type_product as $tp)
                            <div class="col-sm-4">
                                <div class="single-item">
                                    <div class="single-item-header">
                                        <a href=""><img width="200" height="200"
                                                src="/source/image/product/{{$tp->image}}" alt=""></a>
                                    </div>
                                    <div class="single-item-body">
                                        <p class="single-item-title">{{$tp->name}}</p>
                                        <p class="single-item-price" style="text-align:left;font-size: 15px;">
                                            @if($tp->promotion_price==0)
                                            <span class="flash-sale">{{number_format($tp->unit_price)}} Đồng</span>
                                            @else
                                            <span class="flash-del">{{number_format($tp->unit_price)}} Đồng </span>
                                            <span class="flash-sale">{{number_format($tp->promotion_price)}} Đồng</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="single-item-caption">
                                        <a class="add-to-cart pull-left" href="/addtocart/{{$tp->id}}"><i
                                                class="fa fa-shopping-cart"></i></a>
                                        <a class="add-to-cart pull-left" href=""><i class="fa fa-heart"></i></a>
                                        <a class="beta-btn primary" href="/detail/{{$tp->id}}">Details <i
                                                class="fa fa-chevron-right"></i></a>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div>{{$type_product->links()}}</div>
                    </div>
                    <!-- .beta-products-list -->

                    <div class="space50">&nbsp;</div>

                    <div class="beta-products-list">
                        <h4>Top Products</h4>
                        <div class="beta-products-details">
                            <p class="pull-left">{{count($top_products)}} styles found</p>
                            <div class="clearfix"></div>
                        </div>
                        <div class="row">
                            @foreach($top_products as $top_pro)
                            <div class="col-sm-4">
                                <div class="single-item">
                                    <div class="single-item-header">
                                        <a href=""><img width="200" height="200"
                                                src="/source/image/product/{{$top_pro->image}}" alt=""></a>
                                    </div>
                                    <div class="single-item-body">
                                        <p class="single-item-title">{{$top_pro->name}}</p>
                                        <p class="single-item-price" style="text-align:left;font-size: 15px;">
                                            @if($top_pro->promotion_price==0)
                                            <span class="flash-sale">{{number_format($top_pro->unit_price)}}
                                                Đồng</span>
                                            @else
                                            <span class="flash-del">{{number_format($top_pro->unit_price)}} Đồng
                                            </span>
                                            <span class="flash-sale">{{number_format($top_pro->promotion_price)}}
                                                Đồng</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="single-item-caption">
                                        <a class="add-to-cart pull-left" href=""><i class="fa fa-shopping-cart"></i></a>
                                        <a class="add-to-cart pull-left" href="#"><i class="fa fa-heart"></i></a>
                                        <a class="beta-btn primary" href="/detail/{{$top_pro->id}}">Details <i
                                                class="fa fa-chevron-right"></i></a>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="space40">&nbsp;</div>

                    </div> <!-- .beta-products-list -->
                </div>
            </div> <!-- end section with sidebar and main content -->
        </div> <!-- .main-content -->
    </div> <!-- #content -->
</div> <!-- .container -->
@endsection