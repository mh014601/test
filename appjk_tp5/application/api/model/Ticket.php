<?php

namespace app\api\model;

use think\Model;

class Ticket extends Model
{
    // 定义主键 primary key
    protected $pk = 'ticket_id';
    public static function getTicket(){
        return self::select();
    }

}
