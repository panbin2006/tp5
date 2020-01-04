<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/25
 * Time: 16:10
 */

namespace app\lib\exception;


class MatinException extends BaseException
{
    public $code = 401;

    public $message = '材料入库单不存在！';

    public $errorCode = 50000;
}