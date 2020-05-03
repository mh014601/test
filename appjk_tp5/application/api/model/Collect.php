<?php


namespace app\api\model;
use think\Model;

class Collect extends Model
{
    protected $pk="id";
    public static function getInfo($id){
        return self::where("mid",$id)->with("course")->visible(["mid","add_time","did","course.courseName","course.introduce"])->select();
    }
    public function course(){
        return $this->hasMany("Course","id","did");
    }
}
