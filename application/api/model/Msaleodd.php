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

    protected $visible = [
            "SaleID",
            "CoID",
            "PDate",
            "PLine",
            "PlanID",
            "ProjectID",
            "ProjectName",
            "ClassID1",
            "ClassName1" ,
            "CustID" ,
            "CustName",
            "Space",
            "PactItemID",
            "Grade",
            "TSName",
            "tld",
            "Part",
            "BTrans",
            "QualityProd",
            "QualityPlan",
            "QualityGive",
            "CarNum",
            "Quality",
            "BTime",
            "ETime",
            "CarID",
            "CarSJXM",
            "NoteMan",
            "Remark3",
            "QualityTrans",
            "mproductrecms"
    ];

    public static  function getMostRecent($size, $page, $pdateS, $pdateE, $name=''){

       $msaleodds = self::whereBetween('Pdate',[$pdateS, $pdateE])
            ->where('CustName|ProjectName', 'like', '%'.$name.'%')
           ->paginate($size,false, ['page' => $page]);

       return $msaleodds;
    }

    public static function getSummary($pdateS, $pdateE, $name){
        $summary = self::whereBetween('Pdate',[$pdateS, $pdateE])
            ->where('ProjectName|CustName', 'like', '%'.$name.'%')
            ->field(['sum(Quality)' => 'total_quality',
                'sum(QualityProd)' => 'total_qualityProd'])
            ->find();
        return $summary;
    }

    public function mproductrecms(){
        return $this->hasMany('Mproductrecm', 'SaleID', 'KZID');
    }

    public static function getMsaleoddDetail($id){
        $msaleodd =  self::with(['mproductrecms' => function($query){
            $query->order('PiCi desc');
        }])
            ->find($id);
        return $msaleodd;
    }
}