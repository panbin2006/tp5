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
use app\api\model\Syhqx as SyhqxModel;


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

    //验证OpenID
    public function checkOpenID(){
        $flag = 0;
        $msg = 'openid验证失败';
        $params = input('post.');
        $name = $params['name'];
        $code = $params['code'];
        //获取微信openid
        $wxResult = $this->getOpenId($code);

        //查询数据库中用户的openid
        $user = SyhqxModel::getUserByName($name);


        //判断查询否为空。如果为空，把微信获取到的openid保存到数据库
        if($user['Remark1']==''|| is_null($user['Remark1'])){
            $user->save([
                'TrigTag' => !$user['TrigTag'],
                'Remark1' => $wxResult['openid']
            ]);
            $flag = 1;
            $msg = 'openid验证成功';
        } else{//如果不为空，比较微信获取的openid与数据库中用户的openid
            if($user['Remark1'] == $wxResult['openid']){
                $flag = 1;
                $msg = 'openid验证成功';
            }
        }


        return  [
            'wx_openid' => $wxResult['openid'],
            'user_openid' => $user['Remark1'],
            'flag'=> $flag,
            'msg' => $msg
        ];
    }



}