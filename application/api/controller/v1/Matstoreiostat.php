<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020/1/4
 * Time: 16:56
 */

namespace app\api\controller\v1;


use app\api\service\Matstoreiostat as MatstoreiostatService;
use app\lib\exception\MatcwmException;
use think\Exception;
use think\Validate;

class Matstoreiostat
{
    public function getRecent()
    {
        $params = input('post.');

        $matStoreIostatService =  new MatstoreiostatService($params);

        $Tmpcwiostat = $matStoreIostatService->getMatstoreiostat();
        if ($Tmpcwiostat->isEmpty()) {
            throw new Exception();
        }

        //按仓位代码汇总
        $groupData= formatMatStoreIOState($Tmpcwiostat);

         return $groupData;

    }
}