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
//    public $pk ='"CarID", "CoID"';

    public $hidden= [
        'Content',
        'BuyDate',
        'CarTrademark',
        'BuyDate',
        'TypeTag',
        'GZMan',
        'GZTag',
        'GZTagA',
        'GZTime',
        'YangLU',
        'YingYun',
        'BaoXian',
        'Date1',
        'Date2',
        'Pline',
        'Tare',
        'ZhuangTai',
        'Remark1',
        'Remark2',
        'Remark3',
        'Remark4',
        'TrigTag',
        'ExecState',
        'PriceTrans',
        'UnitT',
        'PlanID',
        'ProjectID',
        'SaleID',
        'WGrossBZ',
        'CarYSID',
        'CarZGID',
        'SBID',
        'NoticeStr',
        'SendTag',
        'SendNum',
        'SendMode',
        'DateDaoda',
        'DateXieL',
        'DateBack0',
        'DateBack1',
        'DateGo1',
        'ContentMin',
        'ContentMax',
        'SBColor',
        'SBClass',
        'CarPaiColor',
        'CarClass',
        'CarBZorWZ',
        'CarType2',
        'CarType3',
        'CarType4'
    ];

    public function currentDriver(){
        return $this->hasOne('Sygda', 'YGID', 'SJIDW');
    }

    public function firstDriver(){
        return $this->hasOne('Sygda', 'YGID', 'SJID1');
    }

    public function secondDriver(){
        return $this->hasOne('Sygda', 'YGID', 'SJID2');
    }

    public  static function getByDriverID($driverId){
        $car = self::where('SJID1|SJID2|SJIDW','=',$driverId)->find();
        return $car;
    }
    public static function getMostRecent($size, $page, $zhuangtai )
    {
        $carInfos = self::where('ZhuangTai' , 'like','%' . $zhuangtai.'%')
//            ->fetchSql(true)
            ->paginate($size,false, ['page' => $page]);
        return $carInfos;
    }

    public static function edit($data = '', $where = '', $field = null)
    {
       $result = self::update($data, $where, $field);
       return $result;
    }

    //根据当班司机代码查询车号
    public static function getCarBySjidw($ygid){
        $car = self::where('SJIDW','=', $ygid)->find();
        return $car;
    }

    //根据司机1代码或者司机2代码查询车号
    public static function getCarBySjidOneOrTwo($ygid){
        $car = self::where('SJID1|SJID2','=',$ygid)->find();
        return $car;
    }
}