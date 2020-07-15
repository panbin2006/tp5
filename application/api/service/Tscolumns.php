<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020-07-09
 * Time: 15:10
 */

namespace app\api\service;


use think\Db;
use app\api\model\Tscolumns as TscolumnsModel;
class Tscolumns
{
    //读取系统默认值
    public static  function getDefault($tblId,$defaultFields,$obj){
        $default = TscolumnsModel::where('TblID','=',$tblId)
            ->select($defaultFields);
        foreach ($default as $item) {
            $key = $item['ColsID'];
            $value = $item['iniValue'];
            $obj[$key] = $value;
        }

        return $obj;
    }
}