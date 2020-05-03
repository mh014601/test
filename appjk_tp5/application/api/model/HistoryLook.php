<?php

namespace app\api\model;

use think\Model;

class HistoryLook extends Model
{
    protected $pk="id";
    public static function getCourse($id){
        return self::where("mid",$id)->with("course")->visible(["mid","add_time","cid","course.courseName","course.introduce"])->select();
    }
    public function course(){
        return $this->hasMany("Course","id","cid");
    }
}
