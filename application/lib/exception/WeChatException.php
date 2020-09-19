<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020-09-19
 * Time: 15:05
 */

namespace app\lib\exception;


class WeChatException extends BaseException
{
    public $code = 400;
    public $msg = "微信服务器接口调用失败";
    public $errorCode = 999;
}