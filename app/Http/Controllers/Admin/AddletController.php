<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Cache;


class AddletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('admin.index');
    }

    public function top(){
        return view('admin.top');
    }

    //天气
    public function weather(){
        return view('admin.weather');
    }


    public function weatheres(){
       $city=request()->city;

        //北京 weatherData北京
        $cache_name='weatherData_'.$city;
        $data=Cache::get($cache_name);


        if(empty($data)){
            $url="http://api.k780.com/?app=weather.future&weaid=".$city."&&appkey=47854&sign=358b9a80083c6776e47ec103352f3b7a&format=json";
            $data=file_get_contents($url);
            //缓存数据 只到当天的24点 （获取24点时间--当前时间）
            $time24=strtotime(date("Y-m-d"))+86400;
            $second=$time24-time();
            Cache::put($cache_name,$data,$second);

        }

        //将调接口得到的json格式天气数据返回
        echo $data;die;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
