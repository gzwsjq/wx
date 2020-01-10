@extends('layouts.add')

@section('title', '新闻管理---新闻展示')

@section('content')
    <center><h2>新闻展示</h2></center>
    <form>
        <input type="text" name="name" placeholder="请输入作者" value="{{$query['name']??''}}">
        <select name="tid">
            <option value="0">--请选择--</option>
            @foreach($da as $v)
                <option value="{{$v->tid}}">{{$v->tname}}</option>
            @endforeach
        </select>
        <input type="submit" value="搜索">
    </form>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>新闻标题</th>
            <th>新闻作者</th>
            <th>新闻内容</th>
            <th>添加时间</th>
            <th>操作</th>
        </tr>
        </thead>
            @foreach($data as $v)
                <tbody>
                <tr>
                  <td>{{$v->nid}}</td>
                  <td>{{$v->tname}}</td>
                  <td>{{$v->name}}</td>
                  <td>{{$v->content}}</td>
                  <td style="color:red">{{date('Y-m-d H:i:s',$v->ctime)}}</td>
                    <td>
                        <a href="{{url('news/delete/'.$v->nid)}}">删除</a>
                        <a href="{{url('news/edit/'.$v->nid)}}">编辑</a>
                        <a href="{{url('news/doo/'.$v->nid)}}">详情</a>
                    </td>
                </tr>
                </tbody>
            @endforeach
        <tr><td colspan="6">{{$data->appends($query)->links()}}</td></tr>
    </table>

@endsection
