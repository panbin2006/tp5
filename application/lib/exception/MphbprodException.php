<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/25
 * Time: 16:10
 */

namespace app\lib\exception;


class MphbprodException extends BaseException
{
    public $code = 401;

    public $message = '找不到相应配方！';

    public $errorCode = 80001;
}