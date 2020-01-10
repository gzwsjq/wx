<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class Wx extends Controller
{
    //获取微信接口
    public function wxdo(){
        $url=" https://api.weixin.qq.com/cgi-bin/menu/create?access_token=ACCESS_TOKEN";
        $json=file_get_contents($url);
        $res=json_decode($json,true);
        echo $json;
        print_r($res);

        //缓存token
        $redis_wx_token="wx_access_token";
        Cache::put($redis_wx_token,$res['access_token']);
    }

}
