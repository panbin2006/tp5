<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020/1/4
 * Time: 16:56
 */

namespace app\api\controller\v1;


use app\api\service\Cwiostat as CwiostatService;
use think\Exception;
use think\Validate;

class Tmpcwiostat
{
    public function getRecent()
    {
        $params = input('post.');
        $cwiostatService =  new CwiostatService($params);
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
            'Tmpcwiostat' => $Tmpcwiostat,
            'cwSummary' => $cwSummary,
            'matNameSummary' => $matNameSummary
        ];
    }
}