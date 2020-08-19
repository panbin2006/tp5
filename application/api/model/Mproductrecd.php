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

    protected $resultSetType = 'collection';

    protected $visible = [
        "ProductID",
        "CoID",
        "ItemID",
        "Pline",
        "PDate",
        "Quality",
        "MatID",
        "MatName",
        "MatType",
        "CWID",
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
        "quality_pf",
        "quality_err",
        "quality_sj",
        "err",

    ];

    public static function getMatOut($where,$whereBetween)
    {
        $matOut = self::whereBetween('Pdate', $whereBetween)
            ->where($where)
            ->field([
                'Pline' => 'Pline',
                'CWID' => 'CWID',
                'CWName' => 'CWName',
                'MatID' => 'MatID',
                'MatName' => 'MatName',
                'MatType' => 'MatType',
                'sum(VPF)' => 'quality_pf',
                'sum(VERR)' => 'quality_err',
                'sum(VSJ)' => 'quality_sj'])
            ->group('Pline,CWID,CWName,MatID,MatName,MatType')
            ->order('Pline,MatType desc')
            ->select();
        return $matOut;
    }



}