<?php


namespace app\api\controller\V1;
use think\Db;
use think\Request;

class HistoryLook
{
    public function index(){
        $token=request()->param('token');
        $cache=cache($token);
        $id = $cache['id'];
        $rows = \app\api\model\HistoryLook::getCourse($id);

        return json(['error_code'=>0,'msg'=>$rows],200);
    }
}