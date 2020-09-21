<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020-09-19
 * Time: 11:14
 */

namespace app\api\service;


use app\api\model\Syhqx;
use app\lib\exception\TokenException;
use app\lib\exception\UserException;
use app\lib\exception\WeChatException;
use app\api\model\Syhqx as SyhqxModel;
use think\Exception;

class UserToken extends Token
{
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    function __construct($code)
    {
        $this->code = $code;
        $this->wxAppID = config('wx.app_id');
        $this->wxAppSecret = config('wx.app_secret');
        $this->wxLoginUrl = sprintf(config('wx.login_url'),
            $this->wxAppID, $this->wxAppSecret, $this->code);
    }

    public function get($yhid){
        $result = curl_get($this->wxLoginUrl);
        $wxResult = json_decode($result, true);
        if(empty($wxResult)){

            throw  new Exception('获取session_key与openID时异常，微信内部错误');

        }else{
            $loginFail = array_key_exists('errcode', $wxResult);
            if($loginFail){
                $this->processLoginError($wxResult);
            }else{
                return $this->grantToken($wxResult,$yhid);
            }
        }
    }

    private function grantToken($wxResult, $yhid){
        //拿到openid
        //数据库里看一下，这个openid是不是已经存在
        //如果存在 则不处理， 如果不存再根据yhid查询用户，并把openid保存到对应用户
        //生成令牌，准备缓存数据， 定入缓存
        //把令牌返回到客户端去
        //key:令牌
        //value:wxResult,yhid,scope
        $openid = $wxResult['openid'];
        $user = SyhqxModel::getuserByOpenid($openid);
        if($user){
            $uid = $user->YHID;
        }else{
            $user = Syhqx::getUserByYhid($yhid);
            if($user){
                $uid =  $this->saveUser($user, $openid);
            }else{
                throw new UserException();
            }
        }
        $cashedValue = $this->prepareCashedValue($wxResult, $uid);
        $token = $this->saveToCach($cashedValue);
        return $token;
    }

    //写入缓存,返回令牌
    private function saveToCach($cashedValue){
        $key = self::generateToken();
        $value = json_encode($cashedValue);
        $expire_in = config('setting.token_expire_in');

        $request = cache($key, $value, $expire_in);
        if(!$request){
            throw new TokenException([
                'msg' => '服务器异常',
                'errorCode' => 10005
            ]);
        }

        return $key;
    }

    //准备缓存数据
    private function prepareCashedValue($wxResult, $uid){
        $cashedValue = $wxResult;
        $cashedValue['uid'] = $uid;
        $cashedValue['scope'] = 16;
        return $cashedValue;
    }

    //保存openid到用户表
    private function saveUser($user,$openid){
        $user['Remark1'] = $openid;
        $user->save();
        return $user->YHID;
    }

    //处理微信登录异常
    private  function processLoginError($wxResult){
        throw new WeChatException([
            'msg' => $wxResult['errmsg'],
            'errorCode' => $wxResult['errcode']
        ]);
    }
}