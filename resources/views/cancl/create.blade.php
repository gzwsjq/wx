@extends('layouts.add')

@section('title', '渠道管理---渠道添加')

@section('content')
    <center><h2>渠道上传</h2></center>

    <form class="form-group has-success" role="form" action="{{url('/cancl/add_do')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group has-success">
            <label class="col-sm-2 control-label" for="inputSuccess">
                渠道名称
            </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputSuccess" name="channel_name" placeholder="请输入渠道名称">
            </div>
        </div>
        &nbsp;  &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
        <div class="form-group has-warning">
            <label class="col-sm-2 control-label" for="inputWarning">
                渠道标识
            </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputSuccess" name="channel_status" placeholder="请输入渠道标识">
            </div>
        </div>
        &nbsp;  &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
        <div class="form-group has-warning">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary block full-width m-b">添加</button>
            </div>
        </div>
    </form>

@endsection
