<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/12
 * Time: 17:00
 */

namespace app\api\controller\v1;


use app\api\validate\Count;
use app\api\validate\PageNumberMustBePositiveInt;
use app\api\model\Bbtld as BbtldModel;

class Bbtld
{
    /**
     * 查询坍落度数据
     * @param int $size     单页记录数
     * @param int $page     页码
     * @return array
     * @throws \app\lib\exception\ParameterException
     */
    public static function getRecent()
    {

        $bbtlds= BbtldModel::getMostRecent();
        if ($bbtlds->isEmpty()) {
            return [
                'data' => []
            ];
        }

//        $data = $bbtlds->getCollection()
//            ->toArray();

        return [
            'data' => $bbtlds
        ];
    }


}