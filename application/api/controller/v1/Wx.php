<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/12
 * Time: 17:00
 */

namespace app\api\controller\v1;
use app\api\service\UserToken;
use app\api\validate\TokenGet;


//微信相关接口服务
class  Wx
{
    //获取微信openId
    public function getOpenId($code)
    {
        (new TokenGet())->goCheck();
        $ut = new UserToken($code);
        $wxResult = $ut->getOpenId();
        return $wxResult;

    }

}