<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020-07-09
 * Time: 15:10
 */

namespace app\api\service;

use app\api\model\Mcustomer as McustomerModel;

class Custmoter
{
    //判断是否存在客户：如果有直接返回客户信息，否则创建客户并返回客户信息
    public static  function hasCust($custName){
        $customer = McustomerModel::getMcustomerByCustName($custName);
        return $customer;
    }
}