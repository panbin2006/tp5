<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/11/14
 * Time: 11:12
 */

namespace app\api\validate;


class UserValidate extends BaseValidate
{
    protected  $rule = [
        'bmid' => 'require',
        'yhid' => 'require',
        'pwd' => 'require'
    ];

    protected $message = [
        'bmid' => '部门不能为空',
        'yhid' => '用户不能为空',
        'pwd' => '密码不能为空'
    ];

//    protected $rule = [
//        'id'=>'require|isPositiveInteger',
//    ];
//
//    protected  $message = [
//        'id' => 'id必须是正整数'
//    ];
}