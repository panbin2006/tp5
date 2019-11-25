<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/11/25
 * Time: 11:09
 */

namespace app\api\validate;


class Count extends  BaseValidate
{
    protected  $rule=[
        'count' => 'isPositiveInteger|between:1,15'
    ];
}