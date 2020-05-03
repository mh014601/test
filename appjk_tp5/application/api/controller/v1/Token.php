<?php

namespace app\api\controller\v1;

use think\Controller;
use think\Request;
use app\api\model\Member as MemberModel;
use think\Validate;

class Token extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function getToken()
    {
        // 请求的参数数组
        $request_data = request()->param('');
//        dump(input('get.'));die;
        // 参数过滤
        $validater = new Validate();
        $validater->rule([
            'username'=>'require',
            'password'=>'require'
        ]);
        $result= $validater->check($request_data);
        if(!$result){
            return json(['error_code'=>10001,'msg'=>$validater->getError()],402);
        }
        // 查询数据库, 获取用户信息
        $member_info = MemberModel::getMemberInfo($request_data);
        if($member_info){
            // 生成token返回, 足够随机, 不重复
            $token = md5(uniqid(time()));
            // 保存token
            cache($token, $member_info, 7200);
            // 返回token
            return json(['error_code' => 0, 'data' => ['token' => $token]], 200);
        }else{
            return json(['error_code' => 10004, 'msg' => '用户名或密码不正确'], 401);
        }

    }


}
