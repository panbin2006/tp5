<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/9
 * Time: 14:20
 */

namespace app\api\validate;


use app\lib\enum\MpactStatusEnum;

class MpactStatus extends  BaseValidate
{
    protected $rule = [
        'state' => 'isState'
    ];

    protected $message = [
        'state' => 'state参数错误，系统不存在此工程状态!'
    ];

    protected function isState($value)
    {
        $mpactStatusEnum = new MpactStatusEnum();
        $class =  new \ReflectionClass($mpactStatusEnum);
        $consts = $class->getConstants();
        $isState = in_array($value, $consts);
        if($isState){
            return true;
        }
        return false;
    }
}