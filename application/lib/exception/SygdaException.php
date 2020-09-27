<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/11/12
 * Time: 10:52
 */

namespace app\lib\exception;


class SygdaException extends  BaseException
{
    public $code = 404;
    public $msg = '没有找到对应的员工信息';
    public $errorCode = 20000;
}