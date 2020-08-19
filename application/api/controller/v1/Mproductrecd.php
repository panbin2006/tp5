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
    public  function getSummary()
    {
        //获取查询条件
        $inputs = input('post.');
        $where = [];
        $whereBetween = [];

        $pdateS = $inputs['pdateS'];
        $pdateE = $inputs['pdateE'];
        $pline = $inputs['pline'];
        $searchtxt = $inputs['searchtxt'];

        if($pdateS&&$pdateE){//判断客户端上传时间段参数是否存在
            $whereBetween[0] = $pdateS;
            $whereBetween[1] = $pdateE;
        }else{
            $date_now = date('Y-m-d');
            $whereBetween[0] = $date_now . ' 00:00:00';
            $whereBetween[1] = $date_now . ' 23:59:59';
        }

        if($pline){
            $where['Pline'] = $pline;
        }
        if($searchtxt){ //判断客户端上传的搜索字符串
            $where['MatName|CWName']= ['like','%'.$searchtxt.'%'];
        }

        $matOut = MproductrecdModel::getMatOut($where,$whereBetween);

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