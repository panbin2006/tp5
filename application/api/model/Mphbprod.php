<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2021-01-30
 * Time: 11:03
 */

namespace app\api\model;


use think\Model;

class Mphbprod extends Model
{
    protected  $hidden = [
            "iden_id",
            "EditTag",
            "SHMan",
            "SHTag",
            "SHTagA",
            "SHTime",
            "GZMan",
            "GZTag",
            "GZTagA",
            "GZTime",
            "JBSJ",
            "Fother1",
            "Fother2",
            "Fother3",
            "Sother1",
            "Sother2",
            "Sother3",
            "Sother4",
            "EditTagA",
            "EditTagB",
            "BiaoJi",
            "BTrans",
            "Part",
            "TestMPaKZ",
            "TestMPaKS",
            "XL1",
            "XL2",
            "XL3",
            "XL4",
            "XL5",
            "XL6",
            "Remark1",
            "Remark2",
            "Remark3",
            "Remark4",
            "TrigTag",
            "BZRZ",
            "MaxSN",
            "MinSN",
            "MaxFMH",
            "MinFMH",
            "MaxKF",
            "MinKF",
            "MaxSZ",
            "MinSZ",
            "MaxSha",
            "MinSha",
            "MaxJSJ",
            "MinJSJ",
            "MaxFSJ",
            "MinFSJ",
            "MaxPZJ",
            "MinPZJ",
            "MaxShui",
            "MinShui",
            "CLSN",
            "CLFMH",
            "CLKF",
            "CLSZ",
            "CLSha",
            "CLJSJ",
            "CLFSJ",
            "CLPZJ",
            "CLShui",
            "CLSF",
            "MaxSF",
            "MinSF",
            "MaxRZ",
            "MinRZ",
            "ROW_NUMBER"
    ];

    public static function getMostRecent($size, $page, $where){
        $mphbprods =  self::where($where)
            ->field(['PhbID','PLine','PhbName','Grade','tld','BTrans','CreateTime','Weight'])
            ->order('Grade asc')
//            ->fetchSql(true)
            ->paginate($size, false, ['page' => $page]);
        return $mphbprods;
    }


    public static function getOne($pline, $phbid){
        $mphbprods =  self::get(['PLine' => $pline, 'PhbID' => $phbid]);
        return $mphbprods;
    }
}