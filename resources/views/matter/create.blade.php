@extends('layouts.add')

@section('title', '素材管理---素材添加')

@section('content')
    <center><h2>素材上传</h2></center>

    <form class="form-group has-success" role="form" action="{{url('/matter/add_do')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group has-success">
            <label class="col-sm-2 control-label" for="inputSuccess">
                素材名称
            </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputSuccess" name="media_name" placeholder="请输入素材名称">
            </div>
        </div>
        &nbsp;  &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
        <div class="form-group has-warning">
            <label class="col-sm-2 control-label" for="inputWarning">
                素材文件
            </label>
            <div class="col-sm-10">
                <input type="file" class="form-control" id="inputWarning" name="media_photo">
            </div>
        </div>
        &nbsp;  &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
        <div class="form-group has-success">
            <label class="col-sm-2 control-label" for="inputSuccess">
                素材类型
            </label>
            <div class="col-sm-10">
                <select name="media_type">
                    <option value="0">--请选择--</option>
                    <option value="1">临时素材</option>
                    <option value="2">永久素材</option>
                </select>
            </div>
        </div>
        &nbsp;  &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
        <div class="form-group has-success">
                <label class="col-sm-2 control-label" for="inputSuccess">
                    素材格式
                </label>
                <div class="col-sm-10">
                    <select name="media_format">
                        <option value="0">--请选择--</option>
                        <option value="image">图片</option>
                        <option value="video">视频</option>
                        <option value="voice">语音</option>
                        <option value="thumb">缩略图</option>
                    </select>
                </div>
        </div>
        <div class="form-group has-warning">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary block full-width m-b">添加</button>
            </div>
        </div>
    </form>

@endsection
