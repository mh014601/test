<?php

namespace app\api\model;

use think\Model;

class Member extends Model
{

    protected $pk = "id";
    public static function getMemberInfo($data){
        $username = $data['username'];
        $password = md5("yunhe_".md5($data['password']));
        return self::where('username',$username)->where('password',$password)->find()->toArray();
    }
    public static function getMember($id) {
        dump(self::with(['ticket', 'Course'])->find($id));die;
    }

    public function ticket() {
        return $this->hasMany('Ticket');
    }

    public function course() {
        return $this->belongsToMany('Course');
    }
    public static function dmjxiaopass($id,$pass){
        $user = self::get($id);
        $user->password    = md5('yunhe_'.md5($pass));
        $bool = $user->save();
        return $bool;
    }
    public static function editPhone($id,$phone){
        $user = self::get($id);

        $user->mobile  = $phone;

        $bool = $user->save();

        return $bool;
    }
    public static function loginAction($data){
        $mobile = $data['phone'];
        $password = md5("yunhe_".md5($data['password']));
        return self::where('mobile',$mobile)->where('password',$password)->find();

    }
    public static function loginAction2($data){
        $mobile = $data['phone'];
      return self::where('mobile',$mobile)->find();

    }
    public static function loginAction3($data){
        $mobile = $data['phone'];
        $info = ['mobile'=>$mobile];
      return self::insert($info);

    }
}
