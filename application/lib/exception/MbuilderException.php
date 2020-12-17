<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/9
 * Time: 16:59
 */

namespace app\lib\exception;


class MbuilderException extends  BaseException
{
    public $code = 404;

    public $message = '请求的施工不存在';

    public  $errorCode = 30004;
}