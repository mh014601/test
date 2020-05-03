<?php


namespace app\api\model;

use think\Model;

class Download extends Model
{
    protected $pk="id";
    public static function getInfo($id){
        return self::where("mid",$id)->with("course")->visible(["mid","add_time","cid","course.courseName","course.introduce"])->select();
    }
    public function course(){
        return $this->hasMany("Course","id","cid");
    }
}
