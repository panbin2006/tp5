<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020-09-19
 * Time: 10:58
 */

namespace app\api\controller\v1;


use app\api\service\UserToken;
use app\api\validate\TokenGet;

class Token
{
    public function getToken($code=''){
        (new TokenGet())->goCheck();
        $ut = new UserToken($code);
        $token = $ut->get();
        return $token;
    }
}