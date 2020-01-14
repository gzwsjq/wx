<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::any('/wechat/index','Admin\Wechat@index');
Route::any('/wechat/info','Admin\Wechat@info');//phpinfo
Route::any('/wechat/wx','Admin\Wechat@wx');//测试
Route::any('wechat/mass', 'Admin\Wechat@mass');   //群发
Route::any('wechat/masstexting', 'Admin\Wechat@masstexting');   //群发
Route::any('wechat/getuser', 'Admin\Wechat@getuser');   //微信网络授权
Route::get('wechat/auth', 'Admin\Wechat@auth');   //接收code



Route::prefix('admin')->middleware('checklogin')->group(function(){
    Route::get('/','Admin\AddletController@index');//后台首页
    Route::get('/top','Admin\AddletController@top');//主页
    Route::get('/weather','Admin\AddletController@weather');//主页
    Route::get('/weatheres','Admin\AddletController@weatheres');//ajax请求
    Route::get('/login','Admin\LoginController@login');//登录页面
    Route::post('/logindo','Admin\LoginController@logindo');//登录的编辑
});

Route::get('/matter/index','Admin\MatterController@index');//素材管理展示
Route::get('/matter/create','Admin\MatterController@create');//素材管理添加
Route::post('/matter/add_do','Admin\MatterController@add_do');//素材管理添加

Route::get('/news/index','Admin\NewController@index');//新闻的展示
Route::get('/news/create','Admin\NewController@create');//新闻的添加的视图
Route::post('/news/add_do','Admin\NewController@add_do');//新闻管理添加
Route::get('/news/delete/{nid}','Admin\NewController@delete');//新闻管理删除
Route::get('/news/edit/{nid}','Admin\NewController@edit');//新闻管理编辑
Route::post('/news/update/{nid}','Admin\NewController@update');//新闻管理编辑
Route::get('/news/doo/{nid}','Admin\NewController@doo');//详情访问量
Route::get('/news/aoo','Admin\NewController@aoo');//详情访问量
Route::any('/news/show','Admin\NewController@show');//详情访问量

Route::get('/cancl/index','Admin\CanclController@index');//渠道管理展示
Route::get('/cancl/create','Admin\CanclController@create');//渠道管理添加
Route::post('/cancl/add_do','Admin\CanclController@add_do');//添加
Route::get('/cancl/chart','Admin\CanclController@chart');//渠道的图形展示



//测试
Route::get('/wx/wxdo','Wx@wxdo');//access_token

