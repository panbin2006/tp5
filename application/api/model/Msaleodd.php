<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/13
 * Time: 11:51
 */

namespace app\api\model;


use think\Model;

class Msaleodd extends Model
{
    protected $pk = 'SaleID';

    protected $hidden = [
            "iden_id",
            "SendTag",
            "PrintTag",
            "BSTag",
            "unit",
            "BackTag",
            "BackMode",
            "Trait",
            "SHMan",
            "SHTag",
            "SHTagA",
            "SHTime",
            "GZMan",
            "GZTag",
            "GZTagA",
            "GZTime",
            "HideTag",
            "itag",
            "QualityKZ",
            "MoneyKZ",
            "PriceKZ",
            "BiaoJi",
            "DDID",
            "HideTagB",
            "HideTagC",
            "HideTagD",
            "HideTagE",
            "QualityBackGB",
            "GrossBack",
            "NetWeightBack",
            "PriceQT",
            "MoneyQT",
            "isdl",
            "ReportIDBZ",
            "SaleIDBack",
            "ADDType",
            "PriceTag",
            "FLRZ",
            "Remark1",
            "Remark2" ,
            "Remark3",
            "Remark4",
            "TrigTag",
            "DGTag",
            "SaleTag",
            "SaleCOID",
            "TldEye",
            "TldTest",
            "TestID",
            "TestSide",
            "TestAge",
            "FRemark1",
            "FRemark2",
            "FRemark3",
            "ExecState",
            "ShuiLvTag",
            "PriceInfoOld",
            "PriceDownOld",
            "PriceTSOld",
            "PriceTotalOld",
            "MoneySOld",
            "MoneySErr",
            "TransID",
            "QualityTransA",
            "MoneyTransA",
            "DateXLB",
            "DateXLE",
            "TimesXL",
            "TimesWork",
            "TimesXLA",
            "TimesWorkA",
            "workNum",
            "LiCheng",
            "QualityOil",
            "PriceOil",
            "MoneyOil",
            "ODDIDOilOut",
            "CarYSID",
            "CarZGID",
            "UpLoadTag",
            "CarSupplierName",
            "BackType",
            "PriceTransB",
            "MoneyTransB",
            "QualityTransC",
            "PriceTransC",
            "MoneyTransC",
            "TimesWait",
            "TimesTrans",
            "ChaoShiType",
            "RemarkChaoShi",
            "PhbIDShaJ",
            "GBManBack",
            "GBTimeBack",
            "FileMp4Out",
            "FileMp4Back",
            "PostTag",
            "PostState"
    ];

    public static  function getMostRecentByPlanid($size, $page,$where){

        $msaleodds = self::where($where)
            ->field(['Pdate','CarID','CarNum','Quality','QualityGive'])
            ->order('Pdate desc')
            ->paginate($size,false, ['page' => $page]);

        return $msaleodds;
    }

    public static function getSummaryByPlanid($where){
        $summary = self::where($where)
            ->field(['sum(Quality)' => 'total_quality',
                'sum(QualityProd)' => 'total_qualityProd'])
            ->find();
        return $summary;
    }

    public static  function getMostRecent($size, $page,$where,$whereBetween ){

       $msaleodds = self::whereBetween('Pdate',$whereBetween)
            ->where($where)
           ->order('Pdate desc')
           ->paginate($size,false, ['page' => $page]);

       return $msaleodds;
    }

    public static function getSummary($where,$whereBetween){
        $summary = self::whereBetween('Pdate',$whereBetween)
            ->where($where)
            ->field(['sum(Quality)' => 'total_quality',
                'sum(QualityProd)' => 'total_qualityProd'])
            ->find();
        return $summary;
    }

    public static function getSummaryGroup($where,$whereBetween){
        $summaryGroup = self::whereBetween('Pdate',$whereBetween)
            ->where($where)
            ->group('PLine')
            ->field([
                'PLine',
                'sum(Quality)' => 'total_quality',
                'sum(QualityProd)' => 'total_qualityProd'])
            ->select();
        return $summaryGroup;
    }

    public function mproductrecms(){
        return $this->hasMany('Mproductrecm', 'SaleID', 'KZID');
    }

//    车辆资料
    public function carinfo(){
        return $this->hasOne('Carinfo','CarID','CarID');
    }

    public static function getMsaleoddDetail($id){
        $msaleodd =  self::with(['mproductrecms' => function($query){
            $query->order('PiCi desc');
        }])
            ->find($id);
        return $msaleodd;
    }
}