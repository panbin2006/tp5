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
            ->field(['KZName','CWID','CWName','CWType','MatName','KZName as Vpf_field'])
            ->order('CWType')
//            ->fetchSql(true)
            ->select();
        return $mcwsz;

    }

    /**
     * 字段获取器，增加一个mcwsz表中不存在的字段Vpf，保存仓位排序中对应的配方值字段。
     * @param $kzname  仓位设置中的工控排序：1，2，3 ……
     * @return string  生产配方中的配方值字段： YL1, YL2, YL3……
     */
    public function getVpfFieldAttr($kzname)
    {

        return 'YL'.$kzname;
    }

    

}