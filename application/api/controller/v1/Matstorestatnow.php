<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020/1/4
 * Time: 16:56
 */

namespace app\api\controller\v1;


use app\api\service\Matstorestatnow as MatstorestatnowService;
use app\lib\exception\MatcwmException;
use think\Exception;
use think\Validate;

class Matstorestatnow
{
    public function getRecent()
    {
        $params = input('post.');

        $matStoreStatNowService =  new MatstorestatnowService($params);

        $tmpStoreStat = $matStoreStatNowService->getMatstoreiostat();
        if ($tmpStoreStat->isEmpty()) {
            throw new Exception();
        }

        //按仓位代码汇总
        $groupData= formatMatStoreIOState($tmpStoreStat);

         return $groupData;

    }
}