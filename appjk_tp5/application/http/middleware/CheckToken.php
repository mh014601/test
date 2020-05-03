<?php

namespace app\http\middleware;
use think\Validate;
class CheckToken
{
    public function handle($request, \Closure $next)
    {
        // 没传token报错
        $request_data = request()->param('');
        // 参数过滤
        $validater = new Validate();
        $validater->rule([
            'token'=>'require'
        ]);
        $result= $validater->check($request_data);
        if(!$result){
            return json(['error_code'=>10001,'msg'=>$validater->getError()],402);
        }
        // 传了, 不对, 也得报错
        $user_info = cache($request_data['token']);
        if(!$user_info){
            return json(['error_code'=>10002,'msg'=>'token不正确!请重新获取!'],403);
        }
        return $next($request);
    }
}
