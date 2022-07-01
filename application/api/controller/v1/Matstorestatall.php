<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020/1/4
 * Time: 16:56
 */

namespace app\api\controller\v1;


use app\api\service\Matstorestatall as MatstorestatallService;
use app\lib\exception\MatcwmException;
use think\Exception;
use think\Validate;

class  Matstorestatall
{
    public function getRecent()
    {
        $params = input('post.');

        $matStoreStatAllService =  new MatstorestatallService($params);

        $tmpStoreStatAll = $matStoreStatAllService->getMatstoreiostat();

        if ($tmpStoreStatAll->isEmpty()) {
            throw new Exception();
        }

        // return $tmpStoreStatAll;
        //按仓位代码汇总
        $groupData= formatMatStoreIOState($tmpStoreStatAll);

         return $groupData;

    }
}