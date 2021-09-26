<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/24
 * Time: 14:34
 */

namespace app\api\model;


use think\Db;
use think\Model;

class Mproductrecm extends Model
{
    protected $pk = 'ProductID';

//    protected $visible = [
//            "ProductID",
//            "CoID",
//            "PDate",
//            "PLine",
//            "KZID",
//            "PiCi",
//            "Quality",
//            "SaleID",
//            "PlanID",
//            "ProjectID",
//            "ProjectName",
//            "CustID",
//            "CustName",
//            "BuildID",
//            "BuildName",
//            "Address",
//            "Grade",
//            "TSID",
//            "TSName",
//            "tld",
//            "Part",
//            "BTrans",
//            "CarID",
//            "PhbIDS",
//            "PhbIDP",
//            "ShaRate1",
//            "ShaRate2",
//            "SZRate1",
//            "SZRate2",
//            "NoteMan",
//            "mproductrecds",
//            "total_mproductds"
//    ];

    public static function getMProdStatDayList($size,$page, $where, $whereBetween){


        $mprodStatDayList =  self::whereBetween('PDate',$whereBetween)
            ->field('sum(isnull(Quality,0)) as Quality,convert(char(10),PDate ,121) as  PDate,ProjectName,CustName,Part,BTrans,PlanID,Grade,TSName,CoID,ProjectID,SaleCOID,SaleTag')
            ->where($where)
            ->group('convert(char(10),PDate ,121),ProjectName,CustName,Part,BTrans,PlanID,Grade,TSName,CoID,ProjectID,SaleCOID,SaleTag')
            ->order('convert(char(10),PDate ,121),ProjectName,CustName,Part,BTrans,PlanID,Grade,TSName,CoID,ProjectID,SaleCOID,SaleTag')
            ->buildSql();



        $mprodStatDayList = Db::table($mprodStatDayList)
            ->alias('d2')
            ->fetchSql(true)
            ->paginate($size, false, ['page' => $page]);

        //多次为 'T1' 指定了列 'ROW_NUMBER'错误，删除多余的代码
        $itemsSql = str_replace(', ROW_NUMBER() OVER ( ORDER BY rand()) AS ROW_NUMBER',' ',$mprodStatDayList->items()[0]);
        //查询分页数据
        $items = Db::query($itemsSql);
        //查询分组记录数
        $total = Db::query($mprodStatDayList->total());
        $total_count =  $total[0]['tp_count'];
        $last_page = ceil($total_count / $size);
        return [
            'current_page' => $page,
            'last_page' => $last_page,
            'total_count' => $total_count,
            'data' => $items
        ];

    }
    public static  function getMostRecent($size,$page, $where, $whereBetween){

        $mproducts = self::whereBetween('Pdate', $whereBetween)
            ->where($where)
            ->order('Pdate desc')
            ->paginate($size,false, ['page' => $page]);

        return $mproducts;
    }

    public static function getSummary($where, $whereBetween){
        $summary = self::whereBetween('Pdate',$whereBetween)
            ->where($where)
            ->field([
                'sum(Quality)' => 'total_quality'])
            ->find();
        return $summary;
    }

    public function mproductrecds(){
        return $this->hasMany('Mproductrecd', 'ProductID', 'ProductID');
    }

    public static function getMproductrecmDetail($id){
        $mproductrecm =  self::with(['mproductrecds' => function($query){
            $query->order('iden_id asc');
        }])
            ->find($id);
        return $mproductrecm;
    }
}