<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/30
 * Time: 16:10
 */

namespace app\api\controller\v1;

use app\api\model\Mproductrecd as MproductrecdModel;
use app\lib\exception\MproductrecdException;

class Mproductrecd
{
    /**
     * 查询材料消耗汇总数据
     * @param $pdateS 开始时间
     * @param $pdateE 截止时间
     * @return array
     * @throws MproductrecdException
     */
    public  function getSummary($pdateS, $pdateE)
    {
        $matOut = MproductrecdModel::getMatOut($pdateS, $pdateE);
        if ($matOut->isEmpty()) {
            throw new MproductrecdException();
        }
        //collection转数组
        $matOutArr = $matOut->toArray();


        //按材料种类汇总
        $matTypeSummary = $this->formatData($matOutArr, 'MatType');


        //材料名称汇总
        $matNameSummary = $this->formatData($matOutArr, 'MatName');
        return [
            'matOutInfo' => $matOut,
            'matTypeSummary' => $matTypeSummary,
            'matNameSummary' => $matNameSummary
        ];
    }



    /**
     * 按指定字段分类汇总数据
     * @param $matOutArr  array   材料消耗汇总数组
     * @param $summaryVal  string  汇总字段
     * @return array
     */
    private  function formatData($matOutArr, $summaryVal){

        //生成汇总数据数组
        $summaryArr = array_column($matOutArr, $summaryVal, $summaryVal);
        foreach ($summaryArr as $key => $val) {
            $summaryArr[$key] = [
                $summaryVal => $val,
                'quality_pf' => 0,
                'quality_sj' => 0,
                'quality_err' => 0,
            ];
        }

        //循环遍历数据集
        foreach ($matOutArr as $item) {
            $key = $item[$summaryVal];
            $summaryArrItem = $summaryArr[$key];

            $summaryArrItem['quality_pf'] += $item['quality_pf'];
            $summaryArrItem['quality_sj'] += $item['quality_sj'];
            $summaryArrItem['quality_err'] += $item['quality_err'];


            $summaryArr[$key] = $summaryArrItem;
        }

        return array_values($summaryArr);
    }

}