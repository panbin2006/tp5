<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020-07-09
 * Time: 15:10
 */

namespace app\api\service;


use app\lib\exception\McwszException;
use app\lib\exception\MphbprodException;
use think\Db;
use app\api\model\Mcwsz as McwszModel;
use app\api\model\Mphbprod as MphbprodModel;
class Mphbprod
{
    public static function getMphprod($pline,$phbid)
    {
        //查询生产线仓位设置
        $mcwsz = McwszModel::getMcwszByPline($pline);
        if($mcwsz->isEmpty()){
            throw  new McwszException();
        }

//        return $mcwsz;
        //查询配方
        $mphbprod = MphbprodModel::getOne($pline, $phbid);
//        return $mphbprod;

        if(!$mphbprod){
            throw new MphbprodException();
        }

        $phbDetail = self::compose($mcwsz,$mphbprod);

        return [
            'mphbprod' => $mphbprod,
            'detail' => $phbDetail
        ];

    }

    /**
     * 循环遍历每一个仓位，读取对应的配方值到字段vpf,show:是否显示仓位
     * @param $mcwsz
     * @param $mphbprod
     * @return mixed
     */
    private static  function  compose($mcwsz,$mphbprod){
        foreach ($mcwsz as $cw){
           $cw['vpf']  =  $mphbprod[$cw['Vpf_field']];
           $cw['defaultShow'] = $mphbprod[$cw['Vpf_field']] > 0;
        }

        return $mcwsz;
    }


}