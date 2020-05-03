<?php

namespace app\api\controller\v1;

use think\Controller;
use think\Request;
use think\Validate;
use app\api\model\Member as MemberModel;

class Phone extends Controller
{
   public function phone(){


//       84df9e9e8bfd70cd74ce30335c2e285b
       $token=request()->param('token');

       $cache=cache($token);

       $phone = request()->param('phone');;
       //测试专用
       $name = $phone;
       cache($name, '1234', 900);
       return json(['error_code' => 0, 'data' => ['msg' => '验证码发送成功']], 200);
//       var_dump($phone);
      //


       header('content-type:text/html;charset=utf-8');

       $sendUrl = 'http://v.juhe.cn/sms/send'; //短信接口的URL
       $math = mt_rand(100000, 999999);
       $smsConf = array(
           'key' => '45a1cab7d9b965d81a9fd2a675002b95', //您申请的APPKEY
           'mobile' => $phone, //接受短信的用户手机号码
           'tpl_id' => '192601', //您申请的短信模板ID，根据实际情况修改
           'tpl_value' => "#code#=" . $math . "&#company#=聚合数据" //您设置的模板变量，根据实际情况修改
       );

       $content = juhecurl($sendUrl,$smsConf,1); //请求发送短信
        $name = md5($phone.time());
       if($content){
           $result = json_decode($content,true);
           $error_code = $result['error_code'];
           if($error_code == 0){
               //状态为0，说明短信发送成功
               cache($name, $math, 900);
//               echo "短信发送成功,短信ID：".$result['result']['sid'];
               return json(['error_code' => 0, 'data' => ['msg' => '验证码发送成功']], 200);
           }else{
               //状态非0，说明失败
               $msg = $result['reason'];
//               echo "短信发送失败(".$error_code.")：".$msg;
               return json(['error_code'=>10003,'msg'=>$msg],300);
           }
       }else{
           //返回内容异常，以下可根据业务逻辑自行修改
           return json(['error_code'=>10004,'msg'=>'验证码发送失败'],500);
       }

   }

   public function editPass(){
       $request_data = request()->param('');
       $token=request()->param('token');

       $cache=cache($token);
       $phone = $cache['mobile'];

       $id = $cache['id'];
       $code = request()->param('code');
       $newpass = request()->param('newpassword');

       //参数过滤
        $validater = new Validate();
        $validater->rule([
            'token'=>'require',
            'code'=>'require',
            'newpassword'=>'require'
        ]);
        $result= $validater->check($request_data);
        if(!$result){
            return json(['error_code'=>10001,'msg'=>$validater->getError()],402);
        }


        $cache=cache($phone);
//           var_dump($cache);
//           var_dump($code);
//           die();

        if ($code == $cache) {
          
        $bool =  \app\api\model\Member::dmjxiaopass($id,$newpass);

          if ($bool) {
             return json(['error_code'=>0,'msg'=>'修改密码成功'],200);
          }else{
             return json(['error_code'=>10002,'msg'=>'修改密码失败'],401);
          }
        }
         return json(['error_code'=>10003,'msg'=>'验证码错误'],404);
        

   }

   public function editPhone(){
       $request_data = request()->param('');
       $token=request()->param('token');
       $cache=cache($token);

       $id = $cache['id'];
       $code = request()->param('code');

       $phone = request()->param('phone');

       //参数过滤
       $validater = new Validate();
       $validater->rule([
           'token'=>'require',
           'code'=>'require',
           'phone'=>'require'
       ]);
       $result= $validater->check($request_data);

       if(!$result){
           return json(['error_code'=>10001,'msg'=>$validater->getError()],402);
       }
       $cache=cache($phone);

       if ($code == $cache) {

           $bool =  \app\api\model\Member::editPhone($id,$phone);

           if ($bool) {
               return json(['error_code'=>0,'msg'=>'修改手机号成功'],200);
           }else{
               return json(['error_code'=>10002,'msg'=>'修改手机号失败'],401);
           }
       }
       return json(['error_code'=>10003,'msg'=>'验证码错误'],404);



   }

   public function login(){
     
      //账号密码登录
      if (!request()->param('code')) {
          $data = request()->param();
          $validater = new Validate();
          $validater->rule([
            'password'=>'require',
            'phone'=>'require'
          ]);
          $result= $validater->check($data);
           if(!$result){
              return json(['error_code'=>10001,'msg'=>$validater->getError()],402);
            }
             $info = MemberModel::loginAction($data); 

           if($info){
            // 生成token返回, 足够随机, 不重复
             $token = md5(uniqid(time()));
            // 保存token
             cache($token, $data, 7200);
            // 返回token
            return json(['error_code' => 0, 'data' => ['token' => $token]], 200);
          }else{
            return json(['error_code' => 10004, 'msg' => '用户名或密码不正确'], 401);
          }
        }else{
          $data = request()->param();
          $code = request()->param('code');
          $phone = request()->param('phone');
          //参数过滤
          $validater = new Validate();
          $validater->rule([
            'code'=>'require',
            'phone'=>'require'
          ]);
          $result= $validater->check($data);
          if(!$result){
           return json(['error_code'=>10001,'msg'=>$validater->getError()],402);
          }
          $this->phone();
          $cache=cache($phone);
        if ($code == $cache) {
          $info = MemberModel::loginAction2($data); 
           if($info){
            // 生成token返回, 足够随机, 不重复
             $token = md5(uniqid(time()));
            // 保存token
             cache($token, $data, 7200);
            // 返回token
            return json(['error_code' => 0, 'data' => ['token' => $token]], 200);
          }else{
            $info = MemberModel::loginAction3($data);
            if ($info) {
             // 生成token返回, 足够随机, 不重复
             $token = md5(uniqid(time()));
            // 保存token
             cache($token, $data, 7200);
            // 返回token
            return json(['error_code' => 0, 'data' => ['token' => $token]], 200);
            }
            
          }
        }else{
          return json(['error_code'=>10003,'msg'=>'验证码错误'],404);
        }
      }
   }

   public function find(){
      $phone = request()->param();
      $validater = new Validate();
          $validater->rule([
            'phone'=>'require'
          ]);
          $result= $validater->check($phone);
      dump($phone);
   }


}
