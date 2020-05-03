<?php

namespace app\api\model;

use think\Model;

class Vip extends Model
{
    // 定义主键 primary key
    protected $pk = 'id';
    public static function getVip(){
        return self::find();
    }
}
