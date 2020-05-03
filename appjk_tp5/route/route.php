<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
//fc049e748c969c6cb91397a692be17c3
Route::group('/',function(){
        Route::get(':version/ticket','api/:version.Ticket/getTicket');
    //获取优惠卷
    Route::get(':version/ticket','api/:version.Ticket/getTicket');
    //获取VIP
    Route::get(':version/addVip','api/:version.Ticket/addVip');
    //历史记录
    Route::get(':version/history','api/:version.Member/history_look');
    Route::get(':version/byTokenGetMid','api/:version.Member/byTokenGetMid');
    //搜索
    Route::get(':version/search','api/:version.Member/search');
    //热门搜索
//    Route::get(':version/hotSearch','api/:version.Member/hotSearch');
    //删除历史记录
    Route::delete(':version/delHistory','api/:version.Member/delHistory');
    //获取热门课程
//    Route::get(':version/hotCourse','api/:version.Member/hotCourse');
    //获取会员专享
//    Route::get(':version/vipCourse','api/:version.Member/vipCourse');
//    获取短信验证码
        Route::get('v1/phone','api/v1.Phone/phone');
        //修改密码
    Route::get('v1/pass','api/v1.Phone/editPass');

    //修改手机号
    Route::get('v1/newphone','api/v1.Phone/editPhone');
    //上传头像
    Route::post('avatar','api/v1.Avatar/avatar');
    //修改昵称
    Route::get('uname','api/v1.Avatar/userName');
    //生词本
    Route::post('v1/words','api/v1.MyWords/index');
    //观看历史
    Route::post('v1/historylook','api/v1.HistoryLook/index');
    //订阅
    Route::post('v1/subcribe','api/v1.Subcribe/index');
    //收藏
    Route::post('v1/collect','api/v1.Collect/index');
    //下载
    Route::post('v1/download','api/v1.Download/index');
    Route::get('getpoucon','api/v1.Avatar/getPoucon');
    Route::get('getavatarandname','api/v1.Avatar/getAvatarAndName');
    //获取打卡数据
    Route::get('getclockdata','api/v1.Avatar/getClockData');
    //写入打卡数据
    Route::post('setclockdata','api/v1.Avatar/setClockData');
})->middleware('CheckToken');
//token获取
Route::get(':version/token','api/:version.Token/getToken');
Route::get(':version/hotSearch','api/:version.Member/hotSearch');
Route::get(':version/search','api/:version.Member/search');
Route::get(':version/vipCourse','api/:version.Member/vipCourse');
Route::get(':version/hotCourse','api/:version.Member/hotCourse');
//Route::get(':version/member/:id','api/:version.Member/getMember');
//Route::get(':version/getVip','api/:version.Member/getVip');
Route::get(':version/index','api/:version.Index/getIndex');
//课程详情
Route::get('v1/detail','api/v1.Detail/getDetail');
//课程介绍
Route::get('v1/course','api/v1.Course/getCourse');
//加入vip
Route::get('v1/vip','api/v1.Vip/getVip');
//登录
Route::post('v1/login','api/v1.Phone/login');
//找回密码
Route::post('v1/find','api/v1.Phone/find');