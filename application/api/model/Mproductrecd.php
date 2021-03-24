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

//    protected $visible = [
//        "ProductID",
//        "CoID",
//        "ItemID",
//        "Pline",
//        "PDate",
//        "Quality",
//        "MatID",
//        "MatName",
//        "MatType",
//        "CWID",
//        "CWName",
//        "CWType",
//        "VPF",
//        "VSJ",
//        "VErr",
//        "VPFS",
//        "VSJS",
//        "VErrS",
//        "ErrRate",
//        "RecTag",
//        "Remark",
//        "SaleID",
//        "EditMan",
//        "quality_pf",
//        "quality_err",
//        "quality_sj",
//        "err",
//
//    ];

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
                'sum(VSJ)' => 'quality_sj',
                'sum(VERR)' => 'quality_err'])
            ->group('Pline,CWID,CWName,MatID,MatName,MatType')
            ->order('Pline,MatType desc')
            ->select();
        return $matOut;
    }

    /**
     * 根据productid查询单盘料的消耗合计
     * @param $id  生产记录单号
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getSummary($id){
        $summary = self::where('productid','=',$id)
        ->field([
            'SUM(VPFS)' => 'total_vpfs',
            'SUM(VSJS)' => 'total_vsjs',
           'SUM(VPF)' => 'total_vpf',
            'SUM(VSJ)' => 'total_vsj',
            'SUM(VErr)' => 'total_verr',
        ])->select();
        return $summary;
    }


}