<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Model\Chan;
use App\Tools\Wechats;
use App\Tools\Curl;

class CanclController extends Controller{
    //列表展示视图
    public function index(){
        $data=Chan::get();
        return view('cancl.index',['data'=>$data]);
    }

    //添加的视图展示、
    public function create(){
        return view('cancl.create');
    }

    //添加的操作
    public function add_do(){
        //接值
        $channel_name=request()->channel_name;
        $status=request()->channel_status;


         //调用微信生成带参数的二维码接口
        $access_token=Wechats::getAccessToken();
        //地址
        $url="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$access_token;

        //参数
        $postData='{"expire_seconds": 2592000, "action_name": "QR_STR_SCENE", "action_info": {"scene": {"scene_str": "'.$status.'"}}}';
//        $postData=[
//            'expire_seconds'=>2592000,
//            'action_name'=>"QR_STR_SCENE",
//            'action_info'=>[
//                'scene'=>[
//                    'scene_str'=>$status
//                ],
//            ],
//        ];
//        $postData=json_encode($postData,JSON_UNESCAPED_UNICODE);
        //发送请求
        $res=Curl::post($url,$postData);
        $res=json_decode($res,true);
        $ticket=$res['ticket'];

        $chan=Chan::create([
            'channel_name'=>$channel_name,
            'channel_status'=>$status,
            'ticket'=>$ticket,
        ]);
        if($res){
            echo "<script>alert('添加成功');location.href='/cancl/index'</script>";
        }

    }


    //图形的展示
    public function chart(){
        //查询用户表
        $chan=Chan::get()->toArray();

        $xStr="";
        $ystr="";
        foreach($chan as $key=>$value){
            $xStr.='"'.$value['channel_name'].'",';
            $ystr.=$value['number'].',';
        }
        $xStr=rtrim($xStr,',');
        $ystr=rtrim($ystr,',');

        //显示图形的视图
        return view('cancl.chart',['xStr'=>$xStr,'ystr'=>$ystr]);
    }
}
