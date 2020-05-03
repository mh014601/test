<?php

namespace app\api\controller\V1;

use think\Controller;
use think\Request;
use think\Validate;
use app\api\model\Course as CourseModel;

class Course extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function getCourse()
    {
        //请求的参数数组
        $request_data = request()->param('');
        //参数过滤
        $row = CourseModel::getCourse($request_data);
        
        if($row){
            // // 生成token返回, 足够随机, 不重复
            // $token = md5(uniqid(time()));
            // // 保存token
            // cache($token, $row, 7200);
            // 返回token
            return json(['error_code' => 0, 'data'=>['row'=>$row]], 200);
        }else{
            return json(['error_code' => 10004, 'msg' => '路径不正确!'], 401);
        }
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
