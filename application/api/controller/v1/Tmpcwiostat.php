<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020/1/4
 * Time: 16:56
 */

namespace app\api\controller\v1;


use app\api\service\Cwiostat as CwiostatService;
use app\lib\exception\MatcwmException;
use think\Exception;
use think\Validate;

class Tmpcwiostat
{
    public function getRecent()
    {
        $params = input('post.');
        $cwiostatService =  new CwiostatService($params);
        //从盘点表查询最后一次盘点时间
        $bDate = $cwiostatService->getBdate();

        if(!$bDate){ //如果没有盘点记录，抛异常
            throw new MatcwmException();
        }
        $Tmpcwiostat = $cwiostatService->getCwiostat();
        new Validate();
        if ($Tmpcwiostat->isEmpty()) {
            throw new Exception();
        }

        //collection转数组
        $TmpcwiostatArr= $Tmpcwiostat->toArray();

        //要汇总的数据字段
        $sumItems = [
            "NetBefore",
            "NetIn",
            "NetOutSJ",
            "NetkgR"
        ];
        //按仓位代码汇总
        $cwSummary = formatData($TmpcwiostatArr, 'CWName', $sumItems);


        //材料名称汇总
        $matNameSummary = formatData($TmpcwiostatArr, 'MatName', $sumItems);
        return [
            'bdate' => $bDate,
            'Tmpcwiostat' => $Tmpcwiostat,
            'cwSummary' => $cwSummary,
            'matNameSummary' => $matNameSummary
        ];
    }
}