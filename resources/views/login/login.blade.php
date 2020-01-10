@extends('layouts.add')

@section('title', '后台登录')

@section('content')
    <center><h2>后台登录</h2></center>

    <form class="form-group has-success" role="form" action="{{url('/admin/logindo')}}" method="post">
        @csrf
        <div class="form-group has-success">
            <label class="col-sm-2 control-label" for="inputSuccess">
              用户名
            </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputSuccess" name="account" placeholder="请输入用户名">
            </div>
        </div>
        <div class="form-group has-warning">
            <label class="col-sm-2 control-label" for="inputWarning">
                密码
            </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputWarning" name="pwd" placeholder="请输入密码">
            </div>
        </div>
        <div class="form-group has-warning">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary block full-width m-b">登 录</button>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-10">
                <p class="text-muted text-center"> <a href="login.html#"><small>忘记密码了？</small></a> | <a href="register.html">注册一个新账号</a></p>
            </div>
        </div>

    </form>

@endsection
