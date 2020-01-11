<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020/1/11
 * Time: 12:41
 */

namespace app\lib\exception;


class CarinfoExcption extends BaseException
{
    public $code = 401;

    public $msg = '车辆不存在';

    public $errorCode = 60000;
}