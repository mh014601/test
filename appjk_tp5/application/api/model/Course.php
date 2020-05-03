<?php

namespace app\api\model;

use think\Model;

class Course extends Model
{
    protected $pk="id";
    public static function getCourse($data){
        $id = $data['id'];
        return self::where('id',$id)->find()->toArray();
    }
}
