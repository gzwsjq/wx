@extends('layouts.add')

@section('title', '渠道管理---渠道展示')

@section('content')
    <center><h2>渠道展示</h2></center>
    <table class="table">
        <thead>
        <tr>
            <th>编号</th>
            <th>渠道名称</th>
            <th>渠道标识</th>
            <th>渠道二维码</th>
            <th>关注人数</th>
            <th>操作</th>
        </tr>
        </thead>
        @if($data)
            @foreach($data as $v)
                <tbody>
                <tr>
                    <td>{{$v->channel_id}}</td>
                    <td>{{$v->channel_name}}</td>
                    <td>{{$v->channel_status}}</td>
                    <td>
                        <img src="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket={{$v->ticket}}" width="50px" height="50px">
                    </td>
                    <td>{{$v->number}}</td>
                    <td>
                        <a>删除</a>
                        <a>编辑</a>
                    </td>
                </tr>
                </tbody>
            @endforeach
        @endif
    </table>

@endsection
