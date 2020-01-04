<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/30
 * Time: 16:33
 */

namespace app\api\validate;


class StartAndEndValidate extends  BaseValidate
{
    protected $rule = [
        'PdateS' => 'dateFormat:Y-m-d',
        'PdateE' => 'isDate'
    ];

    protected $message = [
        'PdateS' => '开始时间格式不正确',
        'PdateE' => '截止时间格式不正确'
    ];
}