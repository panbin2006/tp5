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

    protected $visible = [
            "ProductID",
            "CoID",
            "PDate",
            "PLine",
            "KZID",
            "PiCi",
            "Quality",
            "SaleID",
            "PlanID",
            "ProjectID",
            "ProjectName",
            "CustID",
            "CustName",
            "BuildID",
            "BuildName",
            "Address",
            "Grade",
            "TSID",
            "TSName",
            "tld",
            "Part",
            "BTrans",
            "CarID",
            "PhbIDS",
            "PhbIDP",
            "ShaRate1",
            "ShaRate2",
            "SZRate1",
            "SZRate2",
            "NoteMan",
            "mproductrecds",
    ];

    public static  function getMostRecent($size, $page, $pdateS, $pdateE, $name=''){

        $mproducts = self::whereBetween('Pdate',[$pdateS, $pdateE])
            ->where('CustName|ProjectName', 'like', '%'.$name.'%')
            ->paginate($size,false, ['page' => $page]);

        return $mproducts;
    }

    public static function getSummary($pdateS, $pdateE, $name){
        $summary = self::whereBetween('Pdate',[$pdateS, $pdateE])
            ->where('ProjectName|CustName', 'like', '%'.$name.'%')
            ->field(['sum(Quality)' => 'total_quality'])
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