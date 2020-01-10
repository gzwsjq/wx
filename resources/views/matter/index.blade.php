@extends('layouts.add')

@section('title', '素材管理---素材展示')

@section('content')
    <center><h2>素材展示</h2></center>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>素材名称</th>
            <th>素材文件</th>
            <th>素材类型</th>
            <th>素材格式</th>
            <th>添加时间</th>
            <th>过期时间</th>
            <th>操作</th>
        </tr>
        </thead>
        @if($data)
            @foreach($data as $v)
        <tbody>
        <tr>
            <td>{{$v['media_id']}}</td>
            <td>{{$v['media_name']}}</td>
            <td>
                @if($v['media_format']=='image')
                <img src="\{{$v['media_photo']}}" width="50px" height="50px">
                    @elseif($v['media_format']=='voice')
                 <audio src="\{{$v['media_photo']}}" controls="controls" width="100px" ></audio>
                  @elseif($v['media_format']=='video')
                    <video src="\{{$v['media_photo']}}"  controls="controls" width="200px"></video>
                @endif
            </td>
            <td>{{$v['media_type']==1?'临时':'永久'}}</td>
            <td>{{$v['media_format']}}</td>
            <td style="color:red">{{date("Y-m-d H:i;s",$v['add_time'])}}</td>
            <td style="color:red">{{date("Y-m-d H:i;s",$v['late_time'])}}</td>
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
