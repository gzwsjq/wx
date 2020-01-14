<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Login;
use DB;

class LoginController extends Controller{
    public function login(){
        return view('login.login');
    }

    public function logindo(){
        $post=request()->except('_token');

        $where=[
            ['account','=',$post['account']],
            ['pwd','=',$post['pwd']]
        ];
        Login::where($where)->update(['ctime'=>time()]);

        $res=Login::where($where)->first();

        //密码错误三次锁定一小时
        $id=Login::where('account','=',$post['account'])->value('id');
        $error_num=Login::where('account','=',$post['account'])->value('error_num');
        $last_error_time=Login::where('account','=',$post['account'])->value('last_error_time');

        if(!empty($res)){
            //清零 错误时间改为null
            Login::where('id',$id)->update(['error_num'=>0,'last_error_time'=>null]);
            //存入session
            session(['login'=>$res]);
            request()->session()->save();//存储到服务端
            echo "<script>alert('登录成功');location.href='/admin'</script>";
        }else{
            //密码错误
             $time=time();

             if(($time-$last_error_time)>=3600){
                 //错误次数改为1  错误时间改为当前时间
                 $res=Login::where('id',$id)->update(['error_num'=>1,'last_error_time'=>$time]);
                 if($res){
                     echo "<script>alert('账号或密码有误，你还有两次机会');location.href='/admin/login';</script>";
                 }
             }

            if($error_num>=3){
                $min=60-ceil(($time-$last_error_time)/60);
                echo "<script>alert('账号或密码错误,请于 $min 分钟后登录');location.href='/admin/login';</script>";
            }else{
                $res=Login::where('id',$id)->update(['error_num'=>$error_num+1,'last_error_time'=>$time]);
                if($res){
                    $num=(3-($error_num +1));
                    echo "<script>alert('账号或密码有误,你还有 $num 次机会');location.href='/admin/login'</script>";
                }
            }
        }


//        if($res){
//            //存入session
//            session(['user'=>$res]);
//            request()->session()->save();//存储到服务器
//            echo "<script>alert('登陆成功');location.href='/admin'</script>";
//        }else{
//            echo "登录失败";
//        }

    }
}
