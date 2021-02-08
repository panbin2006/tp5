<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/25
 * Time: 16:10
 */

namespace app\lib\exception;


class McwszException extends BaseException
{
    public $code = 401;

    public $message = '找不到生产线仓位！';

    public $errorCode = 40003;
}