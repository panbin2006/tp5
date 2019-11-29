<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/11/29
 * Time: 16:48
 */

namespace app\api\validate;


class PageNumberMustBePositiveInt extends BaseValidate
{
    protected  $rule=[
        'page' => 'require|isPositiveInteger'
    ];

    protected  $message=[
        'page' => 'page必须是正整数'
    ];
}