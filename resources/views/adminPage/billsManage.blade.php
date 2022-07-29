@extends('layout.master')
@section('content')
<div>
    <div>
        <h2 class="">Danh sách tất cả các đơn hàng</h2>
    </div>
    <table id="table_admin_product" class="table table-striped display">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">ID_Customer</th>
                <th scope="col">Date_order</th>
                <th scope="col">Total</th>
                <th scope="col">Payment</th>
                <th scope="col">Note</th>
                <th scope="col">Status</th>
                <th scope="col">View detail</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bills as $bill)
            <tr class="products-list-admin">
                <th scope="col">{{ $bill->id }}</th>
                <th scope="col">{{ $bill->id_customer }}</th>
                <th scope="col">{{ $bill->date_order }}</th>
                <th scope="col">{{ $bill->total}}</th>
                <th scope="col">{{ $bill->payment}}</th>
                <th scope="col">{{ $bill->note}}</th>
                <th scope="col">{{ $bill->status}}</th>
                <th scope="col"><a href="" class="btn btn-primary" style="width:80px;">View detail</a>
            </tr>
            @endforeach
        <tbody>
    </table>
</div>
@endsection