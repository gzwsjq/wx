<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Model\News;
use App\Model\Title;
use Illuminate\Support\Facades\Redis;
use App\Tools\Wechats;

class NewController extends Controller{
    //列表的展示
    public function index(){
        //搜索
        $name=request()->name;
        $tid=request()->tid;
        $where=[];
        if($name){
            $where[]=['name','like',"%$name%"];
        }

        if($tid){
            $where[]=['title.tid','like',"%$tid%"];
        }

        //查询主表 写活下拉菜单
        $da=Title::get();

        $data=News::where($where)->leftjoin('title','news.tid','=','title.tid')->paginate(3);
        $query=request()->all();
        return view('news.index',['data'=>$data,'query'=>$query,'da'=>$da]);
    }

    //添加视图的展示
    public function create(){
        //查询主表 写活下拉菜单
        $da=Title::get();
        return view('news.create',['da'=>$da]);
    }

    //添加的编辑
    public function add_do(){
        $post=request()->except('_token');
        $post['ctime']=time();

        $res=News::create($post);
        if($res){
            echo "<script>alert('添加成功');location.href='/news/index'</script>";
        }
    }

    //删除
    public function delete($nid){
         $res=News::where('nid',$nid)->delete();
        if($res){
            echo "<script>alert('删除成功');location.href='/news/index'</script>";
        }
    }

    //编辑
    public function edit($nid){
        $data=News::find($nid);

        //查询主表 写活下拉菜单
        $da=Title::get();

        return view('news.edit',['data'=>$data,'da'=>$da]);
    }

    //编辑的操作
    public function update($nid){
        $post=request()->except('_token');

        $res=News::where('nid',$nid)->update($post);
        if($res){
            echo "<script>alert('修改成功');location.href='/news/index'</script>";
        }
    }

    //访问量
    public function doo($nid){
        $data=DB::table('news')->first();
        Redis::setnx('num_'.$nid,0);
        Redis::incr('num_'.$nid);
        $get=Redis::get('num_'.$nid);
        return view('news.doo',['data'=>$data,'get'=>$get]);
    }


        //微信公众号平台
        public function show(){
            //echo 111;die;
        //提交按钮 微信服务器以get形式 echostr 原样输出echostr即可
//        $echostr=request()->input('echostr');
//        echo $echostr;die;

        //接受完成后 微信公众号内的用户的任何操作 以post/xml形式 发送到配置的url上
        $xml=file_get_contents("php://input");//接收原始的xml或json数据流
        //写入文件里
        file_put_contents("ne.txt","\n".$xml,FILE_APPEND);

        //方便处理 xml=》对象
        $xmlobj=simplexml_load_string($xml);

        //判断 如果是关注
        if($xmlobj->MsgType=="event"&&$xmlobj->Event=="subscribe"){
            //关注时 获取用户基本信息
            //$access_token=Wechats::getAccessToken();
            //dd($access_token);
            $data=Wechats::getUserInfoByOpenId($xmlobj->FromUserName);
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


        //如果是用户发送文本消息
        if($xmlobj->MsgType=="text"){
            $content=trim($xmlobj->Content);
            if($content=="最新新闻"){
                //发送最新新闻内容
                $ko=News::orderBy('nid','desc')->limit(1)->first();
                $ko=json_decode($ko,true);
                //回复文本消息 输出一个xml数据
                Wechats::reposeText($xmlobj,$ko['content']);
            }elseif($n=mb_strpos($content,"新闻")!==false){  //新闻+新闻关键字
                $city=mb_substr($content,$n+2);
                $msg=News::where('tname','like',"%$city%")->join('title','news.tid','=','title.tid')->count();
                if($msg>0){
                    $msg=News::where('tname','like',"%$city%")->join('title','news.tid','=','title.tid')->value('tname');
                    Wechats::reposeText($xmlobj,$msg);
                }else{
                    $msg="暂无相关新闻";
                    Wechats::reposeText($xmlobj,$msg);
                }

            }else{
                //回复文本消息 输出一个xml数据
                Wechats::reposeText($xmlobj,"想吃大火锅");
            }

        }


    }
}
