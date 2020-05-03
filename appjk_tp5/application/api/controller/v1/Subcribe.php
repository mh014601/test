<?php


namespace app\api\controller\V1;

use app\api\model\Subscribe;
use think\Db;
use think\Request;
use think\Validate;

class Subcribe
{
    public function index(){
        $request_data = request()->param('');
        $token = request()->param('token');
        $cache=cache($token);
        $id = $cache['id'];
       $rows = Subscribe::getInfo($id);
        return json(['error_code'=>0,'msg'=>$rows],200);

    }

}