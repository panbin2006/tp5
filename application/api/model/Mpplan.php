<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/12
 * Time: 17:00
 */

namespace app\api\model;


use think\Model;

class Mpplan extends Model
{
    protected $pk = [
       'PlanID',
       'CoID'
    ];

//    protected $visible = [
//            "total_qualityPlan",
//            "total_qualityGive",
//            "total_carNum",
//            "total_qualityWS",
//            "PlanID",
//            "CoID",
//            "Pline",
//            "PDate",
//            "ProjectID",
//            "ProjectName",
//            "CustID",
//            "CustName",
//            "Address",
//            "Grade",
//            "TSName",
//            "tld",
//            "Part",
//            "BTrans",
//            "QualityPlan",
//            "QualityGive",
//            "QualityWS",
//            "CarNum",
//            "SHTag",
//            "ExecState",
//            "Remark1",
//            "Remark2",
//            "msaleodds",
//    ];


    public function msaleodds(){
        return $this->hasMany('Msaleodd', 'PlanID', 'PlanID');
    }

    public static function getMpplanDetail($id){
        $mpplan =  self::with(['msaleodds' => function($query){
                    $query->order('pdate desc');
                }])
            ->find($id);
        return $mpplan;
    }

    public static function getMostRecent($size, $page, $where, $whereBetween){
        $mpplans = self::whereBetween('Pdate',$whereBetween)
            ->where($where)
            ->order('PlanID asc')
            ->field(["PlanID",
                "CoID",
                "Pline",
                "PDate",
                "ProjectID",
                "ProjectName",
                "CustID",
                "CustName",
                "Address",
                "Grade",
                "TSName",
                "tld",
                "Part",
                "BTrans",
                "QualityPlan",
                "QualityGive",
                "QualityWS",
                "CarNum",
                "SHTag",
                "Tag2",
                "ExecState",
                "Remark1",
                "Remark2",
                "ClassName1",])
//            ->fetchSql(true)
            ->paginate($size, false, ['page' => $page]);
        return $mpplans;
    }


    public static function getSummary($where, $whereBetween){
        $summary = self::whereBetween('Pdate',$whereBetween)
            ->where($where)
//            ->fetchSql(true)
            ->field(['sum(QualityPlan)' => 'total_qualityPlan',
                'sum(QualityGive)' => 'total_qualityGive',
                'sum(carNum)' => 'total_carNum',
                'sum(QualityWS)' => 'total_qualityWS'])
            ->find();
        return $summary;
    }


    public static function upSHTag($id,$flag,$userName){
        $mpplan = self::where(['PlanID' => $id])->find();
        $mpplan->TrigTag = '2';
        $mpplan->SHMan = $userName;
        $mpplan->SHTime = date('Y-m-d H:i:s');
        $mpplan->Tag2 = $flag;
        $mpplan->save();
        return $mpplan;
    }
}