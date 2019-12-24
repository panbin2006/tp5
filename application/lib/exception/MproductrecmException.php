<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/24
 * Time: 15:56
 */

namespace app\lib\exception;


class MproductrecmException extends BaseException
{

    public  $code = 401;

    public $message = '生产记录不存在！';

    public $errorCode = 70000;

}