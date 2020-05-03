<?php

namespace app\api\model;

use think\Model;

class CourseDetail extends Model
{
    protected $pk = "id";
    public static function getDetail($data){
        $id = $data['id'];
        return self::where('id',$id)->find();
    }
}

