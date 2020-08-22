<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/24
 * Time: 14:34
 */

namespace app\api\model;


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