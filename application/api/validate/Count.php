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
        'count' => 'isPositiveInteger|between:1,15',
        'size' => 'isPositiveInteger|between:1,15'
    ];

    protected  $message=[
        'count' => 'count必须是1-15之间的整数',
        'size' => 'size必须是1-15之间的整数'
    ];
}