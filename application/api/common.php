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

/**
 * @MatStoreIOState  原始料位库存列表
 * 料位库存分组
 * 粉仓与外加剂按生产线分为：1，2……线、 共享仓
 * 堆仓：仓位类型骨料与其它
 */

function  formatMatStoreIOState($MatStoreIOState){
    //整理好的料位库存列表
    $matStoreList =[];
    //各生产线非共享仓（粉仓与外加剂）
    $MatStore_Lines = [];

    //共享仓（粉仓与外加剂）
    $MatStore_Share = [];

    //堆仓（骨料、其它）
    $MatStore_Heap = [];
    foreach ($MatStoreIOState as  $key => $val){
//       echo $key.$val->StoreID;
        if($val->StoreType=='骨仓'||$val->StoreType=='其它'){ //判断料位类型是不是骨仓、其它
            array_push($MatStore_Heap,$val);
        }elseif (strpos($val->PLine, ',')){
            array_push($MatStore_Share, $val);
        }else{
             $MatStore_Lines[$val->PLine]['plineName'] = $val->PLine;
            $MatStore_Lines[$val->PLine]['plineList'][] = $val;
        }


    }

    $matStoreList['store_line'] =  $MatStore_Lines;
    $matStoreList['store_share'] =  $MatStore_Share;
    $matStoreList['store_heap'] =  $MatStore_Heap;
    return $matStoreList;
}