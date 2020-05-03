<?php

namespace app\api\controller\V1;

use think\Controller;
use think\Db;
use think\Request;
use app\api\model\Vip as VipModel;

class Vip extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function getVip()
    {
        $mid = $this->request->get('id');
        $row = Db::table('two_member')
            ->alias('m')
            ->join(['two_vip'=>'v'],'m.id = v.mid')
            ->where('m.id',$mid)->select();

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
