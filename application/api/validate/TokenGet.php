<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020-09-19
 * Time: 11:02
 */

namespace app\api\validate;


class TokenGet extends BaseValidate
{
    protected $rule=[
        'code' => 'require|isNotEmpty'
    ];

    protected $message = [
        'code' => '没有code,无法获取Token'
    ];
}