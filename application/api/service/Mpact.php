<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020-07-09
 * Time: 15:10
 */

namespace app\api\service;

use app\api\service\Tscolumns as TscolumnsService;
use app\api\service\Code as CodeService;
use app\api\model\Mpactm as MpactmModel;
class Mpact
{
    protected $mpactm;
    protected $custmoter;
    //创建合同
    public static  function create($mpactm,$customer){

        $date = date("Y-m-d H:i:s");
        $newMpactm= self::mappingField($mpactm, $customer);
        //读取字段默认值
        $defaultFields = ['DaysWarn','DaysXY','EditTag','ExecState','GZTag','HideTag','HideTagB','HideTagC','HideTagD','HideTagE',
            'JQTag','JSQJType','MoneyMode','MoneyYWYTC','NoteMan','PayMode','PriceBC','PriceIDOld','PriceKZ','PriceMode','QualityMode',
            'Rate','SaleCoID','SaleTag','SHTag','ShuiLv','ShuiLvTag','Space','StyleMode','TimesXLA','Unit','YWYKTCRate','YWYKTCTag',
            'YWYTCRate','YWYTCTag'];
        $newMpactm =  TscolumnsService::getDefault('MPactM',$defaultFields,$newMpactm);
        $newMpactm['PDate'] = $date;
        //生成工程代码
        $newMpactm['ProjectID']= CodeService::getCode('MPactM',$mpactm['CoID'],1,$date,'');
       //保存合同订单
        $result = MpactmModel::create($newMpactm);
        return $result;
    }

    //把客户信息加到合同中
    private static function mappingField($mpactm,$custmoter){

        //订单要从合同读取的字段名数组
        $Arr = [ 'CustID', 'CustName'];
        foreach ($Arr as $field){
                $mpactm[$field] = $custmoter[$field];
        }

        return $mpactm;
    }
}