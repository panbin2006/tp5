<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2021-02-02
 * Time: 11:48
 */

namespace app\api\model;


use think\Model;

class Mcwsz extends Model
{
    public static function getMcwszByPline($pline)
    {
        $mcwsz = self::where('PLine','like','%'.$pline.'%')
            ->field(['PLine','KZName','CWID','CWName','CWType','MatName','KZName as Vpf_field',$pline.' as pf_pline'])
            ->order('CWType')
//            ->fetchSql(true)
            ->select();
        return $mcwsz;

    }

    /**
     * 字段获取器，增加一个mcwsz表中不存在的字段Vpf，保存仓位排序中对应的配方值字段。
     * @param $kzname  仓位设置中的工控排序：1，2，3 ……
     * @param $data  当前仓位记录数组
     * @return string  生产配方中的配方值字段： YL1, YL2, YL3……
     **/
    public function getVpfFieldAttr($kzname,$data)
    {
        //配方查询的生产线号
        $pf_pline = $data['pf_pline'];
        //仓位设置中的生产线号
        $cw_Pline=$data['PLine'];
        //配方生产线在仓位生产线号数组中的索引
        $index = 0;
        //判断是不是公用仓位
        if(!($cw_Pline==$pf_pline)){
            $cw_Pline_arr = explode(',',$cw_Pline);
            $index = array_search($pf_pline,$cw_Pline_arr);
            $kzname = explode('.',$kzname)[$index];
        }

        return 'YL'.$kzname;
    }

    

}