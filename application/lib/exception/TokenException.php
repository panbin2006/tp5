<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020-09-21
 * Time: 15:06
 */

namespace app\lib\exception;


class TokenException extends BaseException
{
    public $code = 401;
    public $msg = 'Token已过期或无效Token';
    public $errorCode = 10001;

}