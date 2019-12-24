<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/24
 * Time: 15:59
 */

namespace app\api\model;


use think\Model;

class Mproductrecd extends Model
{
    protected $pk = 'ItemID';

    protected $visible = [
            "ProductID",
            "CoID",
            "ItemID",
            "Pline",
            "PDate",
            "Quality",
            "MatName",
            "MatType",
            "CWName",
            "CWType",
            "VPF",
            "VSJ",
            "VErr",
            "VPFS",
            "VSJS",
            "VErrS",
            "ErrRate",
            "RecTag",
            "Remark",
            "SaleID",
            "EditMan",
    ];
}