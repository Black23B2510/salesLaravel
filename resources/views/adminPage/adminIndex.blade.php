@extends('layout.master')
@section('content')
<div class="space50">&nbsp;</div>
<div class="container beta-relative">
    <div class="container">
        <div class="col-12 col-md-6" style="background: green;color:white">Tổng số sản phẩm: {{ $allProducts }}</div>
        <br>
        <br>
        <a href="/billsManage"><button name="" type="" class="btn btn-danger" style="width:80px;">View
                bills</button></a>
    </div>
</div>
<div class="pull-left">
    <h2>List</h2>
</div>
<div class="pull-right">
</div>
<table id="table_admin_product" class="table table-striped display">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Image</th>
            <th scope="col">Name</th>
            <th scope="col">Type</th>
            <th scope="col">Description</th>
            <th scope="col">Unit_price</th>
            <th scope="col">Promotion_price</th>
            <th scope="col">Unit</th>
            <th scope="col">New</th>
            <th scope="col"><a href="{{route('add-product')}}" class="btn btn-primary" style="width:80px;">Add</a>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr class="products-list-admin">
            <th scope="row">{{$product->id}}</th>
            <th><img src="/source/image/product/{{$product->image}}" alt="image" style="height: 100px;" /></th>
            <td>{{$product->name}}</td>
            <td>{{$product->id_type}}</td>
            <td>{{$product->description}}</td>
            <td>{{$product->unit_price}}</td>
            <td>{{$product->promotion_price}}</td>
            <td>{{$product->unit}}</td>
            <td>{{$product->new}}</td>
            <td>
                <a href='admin-edit-form/{{$product->id}}' type="submit" class="btn btn-warning"
                    style="width:80px;">Edit</a>
                <form role="form" action="admin-delete/{{$product->id}}" method="post">
                    @csrf
                    <button name="edit" type="submit" class="btn btn-danger" style="width:80px;">Delete</button>
                </form>
            </td>

        </tr>
        @endforeach
    <tbody>
</table>
<div class="row">{{$products->links()}}</div>
<div class="space50">&nbsp;</div>
</div>
<script>
$(document).ready(function() {
    $('#table_admin_product').DataTable();
});
</script>
@endsection