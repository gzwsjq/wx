<?php

namespace App\Tools;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Curl extends Model{
    //CURL   GET请求
   public static function get($url){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);//设置请求地址
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//返回数据格式
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }


//CURL   POST请求
   public static function post($url,$postData){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);//设置请求地址
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//返回数据格式
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
}
