<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020/1/10
 * Time: 15:33
 */

namespace app\api\model;


use think\Model;

class Carinfo extends Model
{
//    public $pk =["CarID", "CoID"];

    public $visible = [
        "CarID",
        "CoID",
        "ICID",
        "ChePai",
        "SJID1",
        "SJXM1",
        "SJID2",
        "SJXM2",
        "SJIDW",
        "SJXMW",
        "Content",
        "CarType",
        "Price",
        "BCTag",
        "TypeTag",
        "Tare",
        "ZhuangTai",
        "TrigTag",
        "ExecState",
    ];

    public static function getMostRecent($size, $page, $zhuangtai )
    {
        $carInfos = self::where('ZhuangTai' , 'like','%' . $zhuangtai.'%')
//            ->fetchSql(true)
            ->paginate($size,false, ['page' => $page]);
        return $carInfos;
    }

    public static function edit($data = [], $where = [], $field = null)
    {
       $result = self::update($data, $where, $field);
       return $result;
    }


}