<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020/1/2
 * Time: 10:56
 */

namespace app\lib\exception;


class MproductrecdException extends BaseException
{
    public  $code = 401;

    public $message = '材料消耗不存在！';

    public $errorCode = 50001;
}