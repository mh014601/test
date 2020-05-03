<?php


namespace app\api\controller\v1;
use app\api\model\Member as ModelMember;
use think\Controller;
use think\Db;

class MyWords extends Controller
{
    public function index(){

        $token=request()->param('token');
        $cache=cache($token);

        $id = $cache['id'];


        //var_dump($id);die();
        $rows = db('my_words')->where('mid',$id)->select();

//        var $arr = array();
        foreach($rows as $v){
           $wid = $v['wid'];

//           echo $wid;die;
           $wname[] = db('newwords')->where('cid',$wid)->field('word,paraphrase')->select();



        }
//        var_dump($wname);die();
        return json(['error_code'=>0,'msg'=>$wname[0]],200);
    }
}