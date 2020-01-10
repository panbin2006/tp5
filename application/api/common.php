<?php
/**
 * 按指定字段分类汇总数据
 * @param $matOutArr  array   材料消耗汇总数组
 * @param $groupVal  string  汇总条件字段
 * @param $sumItems  array   汇总字段数组
 * @return array
 */
function formatData($matOutArr, $groupVal, $sumItems){

    //生成汇总数据数组
    $summaryArr = array_column($matOutArr, $groupVal, $groupVal);
    $summaryArrItem = [];
    foreach ($summaryArr as $key => $val) {

        $summaryArrItem[$groupVal] = $val;

        for ($i=0; $i<count($sumItems); $i++){
            $groupkey = $sumItems[$i];
            $summaryArrItem[$groupkey] = 0;
        }

        $summaryArr[$key] = $summaryArrItem;
    }

    //循环遍历数据集
    foreach ($matOutArr as $item) {

        $key = $item[$groupVal];
        $summaryArrItem = $summaryArr[$key];

        for ($i=0; $i<count($sumItems); $i++){
            $summaryKey = $sumItems[$i];
            $summaryArrItem[$summaryKey] += $item[$summaryKey];
        }


        $summaryArr[$key] = $summaryArrItem;
    }

    return array_values($summaryArr);
}