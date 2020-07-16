<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020-07-09
 * Time: 15:10
 */

namespace app\api\service;

use app\api\model\Mcustomer as McustomerModel;
use app\api\service\Code as CodeService;
use app\api\service\Tscolumns as TscolumnsService;

class Custmoter
{
    //判断是否存在客户：如果有直接返回客户信息，否则创建客户并返回客户信息
    public static  function hasCust($custName,$coid){
        $pDate = date("Y-m-d H:i:s");
        $customer = McustomerModel::getMcustomerByCustName($custName);
        if(!$customer){
            //生成客户代码
            $customer['CustID'] = CodeService::getCode('MCustomer',$coid,1,$pDate,'');
            //读取字段默认值
            $defaultFields = ['EditTag','ExecState','GZTag','HideTag','HideTagB','HideTagC','HideTagD','HideTagE','SHTag'];
            $customer =  TscolumnsService::getDefault('MCustomer',$defaultFields,$customer);
            //创建客户
            $customer['CustName'] = $custName;
            $customer['CoID'] = $coid;
            $customer['PDate'] = $pDate;
            $customer = McustomerModel::create($customer);
        }
        return $customer;
    }
}