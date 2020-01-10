<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Tools\Wechats;
use App\Model\Matter;
use App\Tools\Curl;

class MatterController extends Controller{
    //列表展示
    public function index(){
       // 测试token
//        $access_token=Wechats::getAccessToken();
//        echo $access_token;die;
        $data=Matter::get()->toArray();

        return view('matter.index',['data'=>$data]);
    }

    //添加的视图
    public function create(){
        return view('matter.create');
    }

    public function add_do(Request $request){
        //接收所有的值
        $post=request()->input();

        //文件上传
        $file = $request->media_photo;
        $ext=$file->getClientOriginalExtension();//得到文件后缀名
        $filename=md5(uniqid()).".".$ext;
        $filePath=$request->media_photo->storeAs('images',$filename);
                                                                        //        if(!$request->hasFile('media_photo')){
                                                                        //            echo "报错";die;
                                                                        //        }
                                                                               // $filePath=$file->store('images');  //store上传的文件的后缀名是框架系统默认

        //调接口=>将图片上传到微信服务器
        $access_token=Wechats::getAccessToken();
        //$type='image';
        $url="https://api.weixin.qq.com/cgi-bin/media/upload?access_token=".$access_token."&type=".$post['media_format'];
        $filePathOdj=new \CURLFILE(public_path()."/".$filePath);
        //curl发送文件需要先通过CURLFILE类处理
        $postData=['media'=>$filePathOdj];
        $res=Curl::post($url,$postData);
        $res=json_decode($res,true);
        if(isset($res['media_id'])){
            $media_id=$res['media_id'];//微信返回的素材id

            //入库
            $matter=Matter::create([
                'media_name'=>$post['media_name'],
                'media_photo'=>$filePath,  //素材上传地址
                'media_format'=>$post['media_format'],
                'media_type'=>$post['media_type'],
                'wechat_media_id'=>$media_id,
                'add_time'=>time(),
                'late_time'=>time()+60*60*24*3,
            ]);
            if($matter){
                echo "<script>alert('添加成功');location.href='/matter/index'</script>";
            }
        }


    }



}
