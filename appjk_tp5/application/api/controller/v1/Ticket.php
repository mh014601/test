<?php

namespace app\api\controller\v1;

use app\api\model\Vip;
use think\Controller;
use think\Request;
use app\api\model\Ticket as TicketModel;

class Ticket extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function addVip(){
      $vip_data=Vip::getVip();
      return json(['error_code'=>0,'data'=>$vip_data],200);
    }
    public function getTicket()
    {
        // 请求数据库, 查数据
        $ticket_data = TicketModel::getTicket();
        // 返回json
        return json(['error_code'=>0,'data'=>$ticket_data],200);
    }
}
