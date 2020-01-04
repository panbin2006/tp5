<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020/1/4
 * Time: 14:57
 */

namespace app\lib\exception;


class MatcwmException extends BaseException
{
    public  $code = 401;

    public $msg = '材料盘点记录不存在！';

    public $errorCode = 50002;
}