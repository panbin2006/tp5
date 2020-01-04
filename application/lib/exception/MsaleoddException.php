<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/24
 * Time: 14:27
 */

namespace app\lib\exception;


class MsaleoddException extends BaseException
{
    public $code = 401;

    public $message = '送货单记录不存在！';

    public $errorCode = 40001;
}