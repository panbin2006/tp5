<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/13
 * Time: 11:43
 */

namespace app\lib\exception;


class MpplanException extends BaseException
{
    public $code = 404;

    public $errorCode = 5000;

    public $message = '计划单不存在';
}