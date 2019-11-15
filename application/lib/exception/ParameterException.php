<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/11/14
 * Time: 10:50
 */

namespace app\lib\exception;


class ParameterException extends BaseException
{
    public  $code = 400;
    public  $msg = '参数错误';
    public  $errorCode = 10000;
}