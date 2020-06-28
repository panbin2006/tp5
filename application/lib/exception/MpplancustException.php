<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/11/25
 * Time: 11:24
 */

namespace app\lib\exception;


class MpplancustException extends  BaseException
{
    public $code = 404;
    public $msg = '订单不存在';
    public $errorCode = '30003';
}