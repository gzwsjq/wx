<?php

namespace App\Tools;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use App\Tools\Curl;

class Wechats extends Model{
    //微信核心类

    const appId="wx1135f9fbcc72574d";
    const appSecret="3de18ef25a6c271964458e76b94a7a36";

    //封装xml数据流
    public static function reposeText($xmlobj,$msg){
        echo "<xml>
                  <ToUserName><![CDATA[".$xmlobj->FromUserName."]]></ToUserName>
                  <FromUserName><![CDATA[".$xmlobj->ToUserName."]]></FromUserName>
                  <CreateTime>".time()."</CreateTime>
                  <MsgType><![CDATA[text]]></MsgType>
                  <Content><![CDATA[".$msg."]]></Content>
               </xml>";die;
    }

    //获取微信调用接口凭证
    public static function getAccessToken(){
        //先判断缓存是否有数据
         $access_token=Cache::get('access_token');
        //有数据直接返回
        if(empty($access_token)){
            //获取access_token （微信接口调用凭证）
            $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".Self::appId."&secret=".Self::appSecret;
            $data=file_get_contents($url);
            $data=json_decode($data,true);
            $access_token=$data['access_token'];
            //如何存储token两小时
            Cache::put('access_token',$access_token,7200);
        }

        //无数据在次进去调用微信接口获取=》存入缓存
        return $access_token;

    }

    //获取用户id
    public static function getUserInfoByOpenId($openid){
        $access_token=Self::getAccessToken();
        $url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
        $data=file_get_contents($url);
        $data=json_decode($data,true);
        return $data;
    }

    //获取微信的带有参数的二维码的接口
    public static function getTicket($status){
        $access_token=Self::getAccessToken();
        //地址
        $url="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$access_token;

        //参数
        $postData=[
            'expire_seconds'=>2592000,
            'action_name'=>"QR_STR_SCENE",
            'action_info'=>[
                'scene'=>[
                    'scene_str'=>$status
                ],
            ],
        ];
        $postData=json_encode($postData,JSON_UNESCAPED_UNICODE);
        //发送请求
        $res=Curl::post($url,$postData);
        $res=json_decode($res,true);
        return $res;
    }




}
