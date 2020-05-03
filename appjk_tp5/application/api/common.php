<?php
/***
 *
 */
function send($phone){
    header('content-type:text/html;charset=utf-8');

    $sendUrl = 'http://v.juhe.cn/sms/send'; //短信接口的URL
    $math = mt_rand(100000, 999999);
    $smsConf = array(
        'key' => '45a1cab7d9b965d81a9fd2a675002b95', //您申请的APPKEY
        'mobile' => $phone, //接受短信的用户手机号码
        'tpl_id' => '192601', //您申请的短信模板ID，根据实际情况修改
        'tpl_value' => "#code#=" . $math . "&#company#=聚合数据" //您设置的模板变量，根据实际情况修改
    );

    $content = juhecurl($sendUrl,$smsConf,1); //请求发送短信
    return $content;
}



/**
 * 聚合数据发短信接口
 * 请求接口返回内容
 * @param  string $url [请求的URL地址]
 * @param  string $params [请求的参数]
 * @param  int $ipost [是否采用POST形式]
 * @return  string
 */
function juhecurl($url,$params=false,$ispost=0){
    $httpInfo = array();
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
    curl_setopt( $ch, CURLOPT_USERAGENT , 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22' );
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 30 );
    curl_setopt( $ch, CURLOPT_TIMEOUT , 30);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
    if( $ispost )
    {
        curl_setopt( $ch , CURLOPT_POST , true );
        curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
        curl_setopt( $ch , CURLOPT_URL , $url );
    }
    else
    {
        if($params){
            curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
        }else{
            curl_setopt( $ch , CURLOPT_URL , $url);
        }
    }
    $response = curl_exec( $ch );
    if ($response === FALSE) {
        //echo "cURL Error: " . curl_error($ch);
        return false;
    }
    $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
    $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
    curl_close( $ch );
    return $response;
}