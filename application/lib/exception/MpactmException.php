<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/11/25
 * Time: 11:24
 */

namespace app\lib\exception;


class MpactmException extends  BaseException
{
    public $code = 404;
    public $msg = '工程合同不存在';
    public $errorCode = '30000';
}