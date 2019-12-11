<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/9
 * Time: 16:59
 */

namespace app\lib\exception;


class McustomerException extends  BaseException
{
    public $code = 404;

    public $message = '请求的客户不存在';

    public  $errorCode = 4000;
}