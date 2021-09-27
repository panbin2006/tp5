<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/13
 * Time: 11:51
 */

namespace app\api\model;


use think\Model;
use think\Db;
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

    /**
     * @param $size
     * @param $page
     * @param $where
     * @param $whereBetween
     * @return array
     * @throws \think\exception\DbException
     */
    public static function getMSaleStatMonthList($size, $page, $where, $whereBetween){


        $msaleStatMonthList=  self::whereBetween('PDate',$whereBetween)
            ->field('convert(char(10),Pdate ,121) as  Pdate,PlanID,ProjectName,CustName,Part,BTrans,Grade,TSName,sum(isnull(QualityProd,0)) as QualityProd,
sum(isnull(Quality,0)) as Quality,sum(isnull(TransNum,0)) as TransNum,HTBH,ProjectID,CoID,SaleCOID,SaleTag ')
            ->where($where)
            ->group('convert(char(10),Pdate ,121),PlanID,ProjectName,CustName,Part,BTrans,Grade,TSName,HTBH,ProjectID,CoID,SaleCOID,SaleTag')
            ->order('convert(char(10),Pdate ,121),PlanID,ProjectName,CustName,Part,BTrans,Grade,TSName,HTBH,ProjectID,CoID,SaleCOID,SaleTag')
            ->buildSql();



        $msaleStatMonthList = Db::table($msaleStatMonthList)
            ->alias('d2')
            ->fetchSql(true)
            ->paginate($size, false, ['page' => $page]);

        //多次为 'T1' 指定了列 'ROW_NUMBER'错误，删除多余的代码
        $itemsSql = str_replace(', ROW_NUMBER() OVER ( ORDER BY rand()) AS ROW_NUMBER',' ',$msaleStatMonthList->items()[0]);
        //查询分页数据
        $items = Db::query($itemsSql);
        //查询分组记录数
        $total = Db::query($msaleStatMonthList->total());
        $total_count =  $total[0]['tp_count'];
        $last_page = ceil($total_count / $size);

        $summary = self::getSummary($where, $whereBetween);
        return [
            'current_page' => $page,
            'last_page' => $last_page,
            'total_count' => $total_count,
            'total_quality'=> $summary['total_quality'],
            'data' => $items
        ];

    }

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