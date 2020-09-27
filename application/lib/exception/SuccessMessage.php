<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/14
 * Time: 10:17
 */

namespace app\lib\exception;


class SuccessMessage extends BaseException
{
    public $code = 201;

    public $msg = 'ok';

    public $errorCode = 0;
}