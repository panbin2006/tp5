<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/13
 * Time: 10:39
 */

namespace app\api\validate;


use app\lib\enum\PlanStatusEnum;

class MpplanStatus extends BaseValidate
{
    protected $rule = [
        'state' => 'isState'
    ];

    protected $message = [
        'state' => '计划单执行状态参数错误'
    ];

    protected function isState($value){
        $planStatusEnum = new PlanStatusEnum();
        $class = new \ReflectionClass($planStatusEnum);
        $consts = $class->getConstants();
        $isState = in_array($value,$consts);
        if($isState){
            return true;
        }

        return false;
    }
}
