@extends('layouts.add')

@section('title', '新闻管路--新闻添加')

@section('content')
    <center><h2>新闻添加</h2></center>

    <form class="form-group has-success" role="form" action="{{url('news/update/'.$data->nid)}}" method="post" enctype="multipart/form-data" action="{{url('news/update/'.$data->nid)}}">
        @csrf
        <div class="form-group has-success">
            <label class="col-sm-2 control-label" for="inputSuccess">
                新闻标题
            </label>
            <div class="col-sm-10">
                <select name="tid">
                    <option value="0">--请选择--</option>
                    @foreach($da as $v)
                        <option value="{{$v->tid}}" @if($data->tid==$v->tid){{'selected'}} @endif>{{$v->tname}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        &nbsp;  &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
        <div class="form-group has-warning">
            <label class="col-sm-2 control-label" for="inputWarning">
                新闻作者
            </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputWarning" name="name" placeholder="请输入新闻作者" value="{{$data->name}}">
            </div>
        </div>
        &nbsp;  &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
        <div class="form-group has-warning">
            <label class="col-sm-2 control-label" for="inputWarning">
                新闻内容
            </label>
            <div class="col-sm-10">
                <textarea name="content">{{$data->content}}</textarea>
            </div>
        </div>
        &nbsp;  &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
        <div class="form-group has-warning">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary block full-width m-b">编辑</button>
            </div>
        </div>
    </form>

@endsection
