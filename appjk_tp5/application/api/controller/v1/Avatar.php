<?php

namespace app\api\controller\v1;

use think\Db;
use think\Request;

class Avatar
{
    /*
     * 修改头像
     */
    public function avatar()
    {

        $token = request()->param('token');

        $cache = cache($token);
        $uid = $cache['id'];

        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('image');
        // 移动到框架应用根目录/uploads/ 目录下
        $info = $file->rule('avatarPhotoName')->move('./uploads/avatar');
        if ($info) {
            // 输出头像图片名称
            $data['error_code'] = 10009;
            $data['msg'] = '头像修改成功';
            $picName = '/uploads/avatar/' . $info->getFilename();
            $data['picName'] = $picName;
            $uInfo = db('member')->where('id', $uid)->find();
            $num = db('member')->where('id', $uid)->update(['avatar' => $picName]);
            if ($num == 1) {
                $oldPicName = substr(strrchr($uInfo['avatar'], '/'), 1);
                unlink('./uploads/avatar/' . $oldPicName);
            }
            $data['error_code'] = 0;
            $data['msg'] = '头像上传成功';
        } else {
            // 上传失败获取错误信息
            if ($file->getError() == '上传文件大小不符！') {
                $data['error_code'] = 10009;
                $data['msg'] = '上传图片过大';
            } else {
                $data['error_code'] = 10010;
                $data['msg'] = '图片格式不正确';
            }
        }
        $str = json_encode($data, 256);
        return str_replace('\\', '', $str);
    }
    /*
     * 修改昵称
     */
    public function userName()
    {
        $uName = request()->param('uname');
        $token = request()->param('token');
        $cache = cache($token);
        $uid = $cache['id'];
        $res = db('member')->where('username', $uName)->find();
        if($res){
            $data['error_code'] = 10011;
            $data['msg'] = '昵称已存在';
        }else{
            db('member')->where('id',$uid)->update(['username'=>$uName]);
            $data['error_code'] = 0;
            $data['msg'] = '昵称修改成功';
        }
        return json($data);
    }
    /*
     * 获取优惠券
     */
    public function getPoucon(){
        $token = request()->param('token');
        $cache = cache($token);
        $uid = $cache['id'];
        $res = db('coupon')->where('mid',$uid)->select();
        return json($res);
    }
    /*
     * 获取头像/昵称
     */
    public function getAvatarAndName(){
        $token = request()->param('token');
        $cache = cache($token);
        $uid = $cache['id'];
        $uname = db('member')->where('id',$uid)->value('username');
        $avatar = db('member')->where('id',$uid)->value('avatar');
        $data['uname'] = $uname;
        $data['avatar'] = $avatar;
        $str = json_encode($data, 256);
        return str_replace('\\', '', $str);
    }
    /*
     * 获取打卡数据
     */
    public function getClockData(){
        $token = request()->param('token');
        $cache = cache($token);
        $uid = $cache['id'];
        $res_arr = db('clock_in')->where('mid',$uid)->select();
        $num = [];
        foreach ($res_arr as $v){
            $num[]['data'] = date('Y-m-d',$v['add_time']);
        }
        return json($num);
    }
    /*
     * 写入打卡数据
     */
    public function setClockData(){
        $token = request()->param('token');
        $cache = cache($token);
        $uid = $cache['id'];
        //当前时间
        $new_time = time();
        //今天过了的时间
        $guo_time = $new_time%86400;
        //今天开始时间
        $open_time = $new_time-$guo_time;
        //今天结束时间
        $end_time = $open_time+86400;

        //先查今天是否有签到
        $qian = db('clock_in')
            ->where('add_time','>',$open_time)
            ->where('add_time','<',$end_time)
            ->where('mid',$uid)->find();
        if($qian){
            $data['error_code'] = 10012;
            $data['msg'] = '已签到';
        }else{
            db('clock_in')->insert(['mid'=>$uid,'add_time'=>$new_time]);
            $data['error_code'] = 0;
            $data['msg'] = '签到成功';
        }
        return json($data);
    }
    public function caches(){
        $uInfo = db('member')->where('id',1)->find();
        cache('11',$uInfo,3600);
        var_dump(cache('11'));
    }
}