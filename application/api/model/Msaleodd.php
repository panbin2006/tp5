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
    ];
}