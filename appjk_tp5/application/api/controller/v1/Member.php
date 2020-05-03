<?php

namespace app\api\controller\v1;
use app\api\model\Member as ModelMember;
use think\Controller;
use think\Db;

class Member extends Controller
{
    public function byTokenGetMid(){
        $token=request()->param('token');
        $cache=cache($token);
        $cache_arr=json_decode($cache,true);
        return $cache_arr['id'];
    }
    public function getMember(){
        $id = request()->param('id');
        ModelMember::getMember($id);
    }
//    public function getvip(){
//       $rows=Db::name('member') ->alias('m')->join('ticket t','m.id=t.mid')->select();
//       return json(['error'=>0,'data'=>$rows],'200');
//    }
public function search(){
        $search=request()->param('search');

        $mid=$this->byTokenGetMid();
        if($search){
            if($mid){
                $row=Db::name('history_look')->where(['historyName'=>$search])->find();
                if(!$row){
                    $data = ['add_time' => time(), 'historyName' => $search,'mid'=>$mid,'search_num'=>1];
                    Db::name('history_look')->data($data)->insert();
                }else{
                    Db::name('history_look')
                        ->where(['historyName'=>$search])
                        ->inc('search_num')
                        ->update();
                }
            }
            $rows=Db::name('course') ->where('courseName','like',"%$search%")->select();
            return json(['error'=>0,'data'=>$rows],'200');
        }else{
            return json(['error'=>10001,'msg'=>'没有输入查询内容'],'404');
        }
}
public function history_look(){

    $mid=$this->byTokenGetMid();
    $rows=Db::name('history_look')->where(['mid'=>$mid]) ->limit(6)->select();
    return json(['error'=>0,'data'=>$rows],'200');
}
public function hotSearch(){
   $rows=Db::name('history_look')
        ->order('search_num', 'desc')
        ->limit(6)
        ->select();
    return json(['error'=>0,'data'=>$rows],'200');
}
public function delHistory(){
   $mid=$this->byTokenGetMid();
    if($mid){
        $row=Db::name('history_look')->where('mid',$mid)->delete();
        if($row){
            $msg='删除成功';
        }else{
            $msg='删除失败';
        }
        return json(['error'=>0,'msg'=>$msg],'200');
    }
}
public function hotCourse(){
    $rows=Db::name('course')->order('sub_num', 'desc')->limit(4)->select();
    return json(['error'=>0,'data'=>$rows],'200');
}
public function vipCourse(){
    $rows=Db::name('course')->where('vip_course',1)->limit(3)->select();
    return json(['error'=>0,'data'=>$rows],'200');
}


}
