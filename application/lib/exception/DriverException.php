<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020/1/14
 * Time: 14:56
 */

namespace app\lib\exception;


class DriverException extends BaseException
{
    public $code = 404;

    public $msg = '用户（驾驶员）不存在';

    public $errorCode = 20001;
}