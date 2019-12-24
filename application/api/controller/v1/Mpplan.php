<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/12
 * Time: 17:00
 */

namespace app\api\controller\v1;


use app\api\validate\Count;
use app\api\validate\MpplanStatus;
use app\api\validate\PageNumberMustBePositiveInt;
use app\api\model\Mpplan as MpplanModel;
use app\lib\exception\MpplanException;

class Mpplan
{
    /**
     * 查询计划单分页数据
     * @param int $size     单页记录数
     * @param int $page     页码
     * @param $pdateS       开始时间
     * @param $pdateE       截止时间
     * @param string $name  工程名称|客户名称
     * @param int $state     执行状态
     * @return array
     * @throws \app\lib\exception\ParameterException
     */
    public static function getRecent($size=15, $page=1, $pdateS, $pdateE, $name='', $state=9)
    {
        (new Count())->goCheck($size);
        (new PageNumberMustBePositiveInt())->goCheck($page);
        (new MpplanStatus())->goCheck($state);

        //执行状态为9，查询全部计划单（状态值小于9的计划）
        $stateOP = $state == 9 ? '<': '=';

        $pageMpplans = MpplanModel::getMostRecent($size, $page, $pdateS, $pdateE, $name, $state, $stateOP);
        $summary = MpplanModel::getSummary($pdateS, $pdateE, $name, $state, $stateOP);
        if ($pageMpplans->isEmpty()) {
            return [
                'current_page' => $pageMpplans->currentPage(),
                'total_count' => $pageMpplans->total(),
                'total_qualityPlan' => 0,
                'total_qualityGive' => 0,
                'total_carNum' => 0,
                'total_qualityWS' => 0,
                'data' => []
            ];
        }

        $data = $pageMpplans->getCollection()
            ->toArray();

        return [
            'current_page' => $pageMpplans->currentPage(),
            'total_count' => $pageMpplans->total(),
            'total_qualityPlan' => $summary['total_qualityPlan'],
            'total_qualityGive' => $summary['total_qualityGive'],
            'total_carNum' => $summary['total_carNum'],
            'total_qualityWS' => $summary['total_qualityWS'],
            'data' => $data
        ];
    }

    /**
     * 根据计划单号查询发货单列表
     * @param $id       计划单号
     * @return \think\response\Json
     * @throws MpplanException
     */
    public static function getOne($id)
    {
        $mpplan = MpplanModel::getMpplanDetail($id);
        if (!$mpplan) {
            throw new MpplanException();
        }
        return json($mpplan);
    }


    public static function setSH($id, $flag){

        $mpplan = \app\api\model\Mpplan::get('190501001');
        $mpplan->DaysXY = '888';
        $mpplan->Remark2= 'pan';
        return $mpplan->save();

    }

}