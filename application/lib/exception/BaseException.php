<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/11/12
 * Time: 10:40
 */

namespace app\lib\exception;


use think\Exception;
use Throwable;

class BaseException extends Exception
{
    //http状态码
    public  $code = "400";

    //错误信息
    public  $msg = '参数错误';

    //错误码
    public  $errorCode = '10000';

    public  function  __construct($params = [])
    {
       if(!is_array($params)){
           return;
       }

       if(array_key_exists('code',$params)){
           $this->code = $params['code'];
       }

       if(array_key_exists('msg', $params)){
           $this->msg = $params['msg'];
       }

       if(array_key_exists('errorCode', $params)){
           $this->errorCode = $params['errorCode'];
       }
    }
}