<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tools\Wechats;
use App\Model\Matter;
use App\Model\Chan;
use App\Model\Status;
use DB;
use App\Tools\Curl;


class Wechat extends Controller{
    private $array=["紫萝卜","水萝卜","绿箩卜","红萝卜","白萝卜"];

    public function index(Request $request){
       //提交按钮 微信服务器以get形式 echostr 原样输出echostr即可
//        $echostr=request()->input('echostr');
//        echo $echostr;die;

        //接受完成后 微信公众号内的用户的任何操作 以post/xml形式 发送到配置的url上
        $xml=file_get_contents("php://input");//接收原始的xml或json数据流
        //写入文件里
        file_put_contents("log.txt","\n".$xml,FILE_APPEND);

        //方便处理 xml=》对象
        $xmlobj=simplexml_load_string($xml);

        //判断 如果是关注
        if($xmlobj->MsgType=="event"&&$xmlobj->Event=="subscribe"){
            //得到渠道的标识  关注人数
            $EventKey=$xmlobj->EventKey;   //标识 qrscene_3333
            $EventKey=mb_substr($EventKey,8);

            $aaa = Chan::where('channel_status','=',$EventKey)->first();
            //根据渠道标识 关注的人数递增
            Chan::where('channel_id',$aaa['channel_id'])->increment('number');

            //关注时 获取用户的基本信息
            $access_token = Wechats::getAccessToken();
            // dd($access_token);
           //获取用户的信息
            $data=Wechats::getUserInfoByOpenId($xmlobj->FromUserName);
            //dd($data);
            $openid=$data['openid'];  //openid


            //查询用户表
            $status=Status::where('openid',$openid)->first();
            //dd($status);
            //判断
            if($status){
                Status::where('openid',$openid)->update(['is_del'=>1,'channel_status'=>$data['qr_scene_str']]);
            }else{
                DB::table('status')->insert([
                    'openid'=>$data['openid'],
                    'status_name'=>$data['nickname'],
                    'status_sex'=>$data['sex'],
                    'status_city'=>$data['country'].$data['province'].$data['city'],
                    'channel_status'=>$data['qr_scene_str'],
                ]);
                //dd($res);
            }

            $nickname=$data['nickname'];//取用户昵称
            $sex=$data['sex'];

            if($sex=='1'){
                $a='男士';
            }else{
                $a='女士';
            }

            $msg="欢迎".$nickname.$a."关注";
            //回复文本消息 输出一个xml数据
            Wechats::reposeText($xmlobj,$msg);
        }

        //判断 如果取消关注
        if($xmlobj->MsgType=="event"&&$xmlobj->Event=="unsubscribe"){
            //获取用户的 信息
            $res=Status::where(['openid'=>$xmlobj->FromUserName])->first();
            $channel_status=$res['channel_status'];   //渠道的标识

            Status::where('channel_status',$channel_status)->update(['is_del'=>2]);

            //查询渠道表 将取消关注的数量减一
            $chan=Chan::where('channel_status',$channel_status)->decrement('number');

        }



        //如果是用户发送文本消息
        if($xmlobj->MsgType=="text"){
            $content=trim($xmlobj->Content);
            if($content=='1'){
                //发送全班同学的姓名
                $ko=implode(',',$this->array);
                //回复文本消息 输出一个xml数据
                Wechats::reposeText($xmlobj,$ko);
            }elseif($content=='2'){
                //回复随机的一个全班同学中最帅的一个
                shuffle($this->array);
                $msg=$this->array[0];
                //回复文本消息 输出一个xml数据
                Wechats::reposeText($xmlobj,$msg);
            }elseif(mb_strpos($content,"天气")!==false){  //城市名字+天气
                $city=rtrim($content,'天气');
                if(empty($city)){
                    $city="北京";
                }

                $url="http://api.k780.com/?app=weather.future&weaid=".$city."&&appkey=47854&sign=358b9a80083c6776e47ec103352f3b7a&format=json";
                $data=file_get_contents($url);
                $data=json_decode($data,true);

                $msg="";
                foreach($data['result'] as $key=>$value){
                    $msg.=$value['days']."".$value['week']."".$value['citynm']."".$value['temperature']."\n";
                }

                Wechats::reposeText($xmlobj,$msg);

            }else{
                //回复文本消息 输出一个xml数据
                Wechats::reposeText($xmlobj,"想吃大火锅");
            }

        }

         //回复图片
        if($xmlobj->MsgType=="image"){
            $res=Matter::where('media_format','=','image')->get()->toArray();
            $arr=array_rand($res);
            $msg=$res[$arr]['wechat_media_id'];
            //dd($msg);
            echo "<xml>
                 <ToUserName><![CDATA[".$xmlobj->FromUserName."]]></ToUserName>
                 <FromUserName><![CDATA[".$xmlobj->ToUserName."]]></FromUserName>
                 <CreateTime>".time()."</CreateTime>
                 <MsgType><![CDATA[image]]></MsgType>
                 <Image>
                 <MediaId><![CDATA[".$msg."]]></MediaId>
                 </Image>
               </xml>";
        }

        //回复语音
        if($xmlobj->MsgType=="voice"){
            $res=Matter::where('media_format','=','voice')->get()->toArray();
            $arr=array_rand($res);
            $msg=$res[$arr]['wechat_media_id'];
            echo "<xml>
                    <ToUserName><![CDATA[".$xmlobj->FromUserName."]]></ToUserName>
                    <FromUserName><![CDATA[".$xmlobj->ToUserName."]]></FromUserName>
                    <CreateTime>".time()."</CreateTime>
                    <MsgType><![CDATA[voice]]></MsgType>
                    <Voice>
                    <MediaId><![CDATA[".$msg."]]></MediaId>
                    </Voice>
                    </xml>";
        }

        //回复视频
        if($xmlobj->MsgType=="video"){
            $res=Matter::where('media_format','=','video')->get()->toArray();
            $arr=array_rand($res);
            $msg=$res[$arr]['wechat_media_id'];
            dd($msg);
            echo"<xml>
                  <ToUserName><![CDATA[".$xmlobj->FromUserName."]]></ToUserName>
                  <FromUserName><![CDATA[".$xmlobj->ToUserName."]]></FromUserName>
                  <CreateTime>".time()."</CreateTime>
                  <MsgType><![CDATA[video]]></MsgType>
                  <Video>
                    <MediaId><![CDATA[media_id]]></MediaId>
                    <Title><![CDATA[title]]></Title>
                    <Description><![CDATA[".$msg."]]></Description>
                  </Video>
                </xml>";
        }


    }


    //测试
    public function wx(){
        $access_token = Wechats::getAccessToken();
        $url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$access_token";
        $wxdo=[
            "button"=>[
        [
            "type"=>"location_select",
            "name"=>"发送位置",
            "key"=>"rselfmenu_2_0",
        ],
      [
          "name"=>"菜单",
           "sub_button"=>[
           [
               "type"=>"view",
               "name"=>"搜索",
               "url"=>"http://www.soso.com/"
            ],
            [
                "type"=>"click",
               "name"=>"赞一下我们",
               "key"=>"V1001_GOOD"
            ]]
       ]]

        ];

        $wxdo=json_encode($wxdo,JSON_UNESCAPED_UNICODE);
        $curl=Curl::post($url,$wxdo);
        var_dump($curl);
    }



    //群发视图
    public function mass(){
        return view('wechat.mass');
    }


    //群发
    public function masstexting(){
        $name = request()->name;
        //dd($name);
        $res = Status::where('is_del','=',1)->select('openid')->get()->toArray();
        $openid = array_column($res,'openid');
        //dd($openid);
        $access_token = Wechats::getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=".$access_token;

        $postData = [
            "touser"=> $openid,
            "msgtype"=>"text",
            "text"=> [
                "content"=>$name
            ]
        ];
        $postData = json_encode($postData,JSON_UNESCAPED_UNICODE);
        $data = Curl::post($url,$postData);
        var_dump($data);
    }

    //网络授权以及获取用户的信息
    public function getuser(){
        $appid=env("WX_APPID");
        $redirect_uri=urlencode(env('WX_AUTH_REDIRECT_URI'));
        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
        echo $url;
    }

    //接收用户的code
    public function auth(){
        $code=$_GET['code'];

        //换取access_token
        $url=" https://api.weixin.qq.com/sns/oauth2/access_token?appid=".env("WX_APPID")."&secret=".env("WX_APPSECRET")."&code=".$code."&grant_type=authorization_code";
        $cdata=file_get_contents($url);
        $arr=json_decode($cdata,true);
    }






}
