@extends('layouts.add')

@section('title', '群发微信消息')

@section('content')

    <form action="{{url('/wechat/masstexting')}}" method="post">
        <textarea name="name" class="form-control" placeholder="请输入要发送的内容..."></textarea>
        <br>
        <button type="submit" class="btn btn-default">点击发送</button>
    </form>

@endsection