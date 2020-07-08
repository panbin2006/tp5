<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/12
 * Time: 17:00
 */

namespace app\api\controller\v1;


use app\api\model\Bbtrans as BbtransModel;

class Bbtrans
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

        $bbtrans= BbtransModel::getMostRecent();
        if ($bbtrans->isEmpty()) {
            return [];
        }

        //取出每一个tld，生成一维数组
        $result = [];
        foreach ($bbtrans as $key=>$val){
            $result[] =  $val->BTrans;
        }

        return $result;
    }


}