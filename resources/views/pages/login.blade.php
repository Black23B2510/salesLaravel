@extends('layout.master')
@section('content')
<div class="inner-header">
    <div class="container">
        <div class="pull-left">
            <h6 class="inner-title">Đăng nhập</h6>
        </div>
        <div class="pull-right">
            <div class="beta-breadcrumb">
                <a href="/">Home</a> / <span>Đăng nhập</span>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="container">
    <div id="content">
        <div>
            @if($errors->any())
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            @endif
        </div>
        <form action="login" method="post" class="beta-form-checkout">
            @csrf
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <h4>Đăng nhập</h4>
                    <div class="space20">&nbsp;</div>
                    <div class="form-block">
                        <label for="email">Email*</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-block">
                        <label for="password">Password*</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="form-block">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </div>
                <div class="col-sm-3"></div>
            </div>
            <div><a href="getInput-email">Quên mật khẩu</a></div>
        </form>
    </div> <!-- #content -->
</div> <!-- .container -->
@endsection