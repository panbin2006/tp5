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
    ];
}