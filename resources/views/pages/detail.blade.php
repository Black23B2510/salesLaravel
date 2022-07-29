@extends('layout.master')
@section('content')
<div class="inner-header">
    <div class="container">
        <div class="pull-left">
            <h6 class="inner-title">Product</h6>
        </div>
        <div class="pull-right">
            <div class="beta-breadcrumb font-large">
                <a href="/">Home</a> / <span>Product</span>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="container">
    <div id="content">
        <div class="row">
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-sm-4">
                        <img src="/source/image/product/{{$product->image}}" alt="">
                    </div>
                    @if($product->promotion_price ==!0)
                    <div class="ribbon-wrapper">
                        <div class="ribbon sale">Sale</div>
                    </div>
                    @endif
                    <div class="col-sm-8">
                        <div class="single-item-body">
                            <p class="single-item-title">{{$product->name}}</p>
                            <p class="single-item-price">
                                @if($product->promotionprice ==0)
                                <span class="flash-sale">{{number_format($product->unit_price)}} Đồng</span>
                                @else
                                <span class="flash-del">{{number_format($product->unit_price)}} Đồng </span>
                                <span class="flash-sale">{{number_format($product->promotion_price)}}Đồng</span>
                                @endif
                            </p>
                        </div>
                        <div class="clearfix"></div>
                        <div class="space20">&nbsp;</div>
                        <div class="single-item-desc">
                            <p>{{$product->description}}</p>
                        </div>
                        <div class="space20">&nbsp;</div>
                        <p>Options:</p>
                        <div class="single-item-options">
                            <select class="wc-select" name="size">
                                <option>Size</option>
                                <option value="XS">XS</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                            </select>
                            <select class="wc-select" name="color">
                                <option>Color</option>
                                <option value="Red">Red</option>
                                <option value="Green">Green</option>
                                <option value="Yellow">Yellow</option>
                                <option value="Black">Black</option>
                                <option value="White">White</option>
                            </select>
                            <select class="wc-select" name="color">
                                <option>Quantity</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            <a class="add-to-cart" href="/addtocart/{{$product->id}}"><i
                                    class="fa fa-shopping-cart"></i></a>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="space40">&nbsp;</div>
                <div class="woocommerce-tabs">
                    <ul class="tabs">
                        <li><a href="#tab-description">Description</a></li>
                        <li><a href="#tab-reviews">Comments</a></li>
                    </ul>
                    <div class="panel" id="tab-description">
                        <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia
                            consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro
                            quisquam est, qui dolorem ipsum quia dolor sit amet.</p>
                        <p>Consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et
                            dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum
                            exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi
                            consequaturuis autem vel eum iure reprehenderit qui in ea voluptate velit es quam nihil
                            molestiae consequr, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur? </p>
                    </div>
                    <div class="panel" id="tab-comment">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card-body">
                                        <form method="post" action="/comment/{{$product->id}}">
                                            @csrf
                                            <div class="form-group">
                                                <textarea class="form-control" name="comment" required></textarea>
                                            </div>
                                            <button type="submit" class="beta-btn primary">Bình luận</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(isset($comments))
                        @foreach($comments as $comment)
                        <p class="border-bottom">
                        <p><b class="pull-left">{{$comment->username}}</b></p><br />
                        <p>{{$comment->comment}}</p>
                        </p>
                        @endforeach
                        @else
                        <p>Chưa có bình luận nào cả!</p>
                        @endif
                    </div>

                </div>
            </div>
            <div class="space50">&nbsp;</div>
            <div class="beta-products-list">
                <h4>Related Products</h4>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="single-item">
                            <div class="single-item-header">
                                <a href="product.html"><img src="/source/image/product/sukem.jpg" alt=""></a>
                            </div>
                            <div class="single-item-body">
                                <p class="single-item-title">Su Kem</p>
                                <p class="single-item-price">
                                    <span>$34.55</span>
                                </p>
                            </div>
                            <div class="single-item-caption">
                                <a class="add-to-cart pull-left" href="product.html"><i
                                        class="fa fa-shopping-cart"></i></a>
                                <a class="beta-btn primary" href="">Details <i class="fa fa-chevron-right"></i></a>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="single-item">
                            <div class="single-item-header">
                                <a href="product.html"><img src="/source/image/product/sukemdau.jpg" alt=""></a>
                            </div>
                            <div class="single-item-body">
                                <p class="single-item-title">Su kem dâu</p>
                                <p class="single-item-price">
                                    <span>$34.55</span>
                                </p>
                            </div>
                            <div class="single-item-caption">
                                <a class="add-to-cart pull-left" href="product.html"><i
                                        class="fa fa-shopping-cart"></i></a>
                                <a class="beta-btn primary" href="product.html">Details <i
                                        class="fa fa-chevron-right"></i></a>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="single-item">
                            <div class="ribbon-wrapper">
                                <div class="ribbon sale">Sale</div>
                            </div>

                            <div class="single-item-header">
                                <a href="#"><img src="/source/image/product/crepe-chuoi.jpg" alt=""></a>
                            </div>
                            <div class="single-item-body">
                                <p class="single-item-title">Crepe chuối</p>
                                <p class="single-item-price">
                                    <span class="flash-del">$34.55</span>
                                    <span class="flash-sale">$33.55</span>
                                </p>
                            </div>
                            <div class="single-item-caption">
                                <a class="add-to-cart pull-left" href="#"><i class="fa fa-shopping-cart"></i></a>
                                <a class="beta-btn primary" href="#">Details <i class="fa fa-chevron-right"></i></a>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- .beta-products-list -->
        </div>
        <div class="col-sm-3 aside">
            <div class="widget">
                <h3 class="widget-title">Best Sellers</h3>
                <div class="widget-body">
                    <div class="beta-sales beta-lists">
                        @foreach($best_seller as $bs)
                        <div class="media beta-sales-item">
                            <a class="pull-left" href="/detail/{{$bs->id}}"><img
                                    src="/source/image/product/{{$bs->image}}" alt=""></a>
                            <div class="media-body">
                                {{$bs->name}}
                                <span class="beta-sales-price">{{number_format($bs->unit_price)}}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div> <!-- best sellers widget -->
            <div class="widget">
                <h3 class="widget-title">New Products</h3>
                <div class="widget-body">
                    <div class="beta-sales beta-lists">
                        @foreach($new_product as $product)
                        <div class="media beta-sales-item">
                            <a class="pull-left" href="/detail/{{$bs->id}}"><img
                                    src="/source/image/product/{{$product->image}}" alt=""></a>
                            <div class="media-bodimagey">
                                {{$product->name}}
                                <span class="beta-sales-price">{{number_format($product->unit_price)}} Đồng</span>
                            </div>
                        </div>
                        @endforeach
                    </div> <!-- best sellers widget -->
                </div>
            </div>
        </div> <!-- #content -->
    </div>
</div>
</div>
<!-- .container -->
<!-- include js files -->
@endsection