<?php


namespace app\api\controller\V1;

use think\Db;
use think\Request;

class Collect
{
    public function index(){
        $token=request()->param('token');
        $cache=cache($token);
        $id = $cache['id'];
//        $rows = \app\api\model\Collect::getInfo($id);
      $rows =   \app\api\model\Collect::getInfo($id);
        return json(['error_code'=>0,'msg'=>$rows],200);
    }
}