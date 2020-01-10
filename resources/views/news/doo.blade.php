@extends('layouts.add')

@section('title', '新闻管理---新闻展示')

@section('content')
    <h1>新闻列表详情页</h1>
    <form>
        @csrf
        <table>
            <tr>
                <td> 访问量:{{$get}}</td>
                <td></td>
            </tr>
            <hr>
            <center>正文</center>
            <tr>
                <td>  ID:{{$data->nid}}</td>
                <td></td>
            </tr>
            <tr>
                <td> 新闻标题:{{$data->name}}</td>
                <td></td>
            </tr>
            <tr>
                <td> 新闻描述：{{$data->content}}</td>
                <td></td>
            </tr>
        </table>

    </form>

@endsection
