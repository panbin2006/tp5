<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/11/12
 * Time: 10:52
 */

namespace app\lib\exception;


class UserException extends  BaseException
{
    public $code = 404;
    public $msg = '用户不存在';
    public $errorCode = 20000;
}