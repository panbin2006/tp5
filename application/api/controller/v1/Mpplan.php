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
use app\api\model\Msaleodd as MsaleoddModel;
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
    public static function getRecent($size=15, $page=1)
    {
        (new Count())->goCheck($size);
        (new PageNumberMustBePositiveInt())->goCheck($page);


        //获取查询条件
        $inputs = input('post.');
        $where = [];
        $whereGroup = []; //按生产线分组的where条件
        $whereBetween = [];
        $pdateS = $inputs['pdateS'];
        $pdateE = $inputs['pdateE'];
        $searchtxt = $inputs['searchtxt'];
        $state = $inputs['state'];
        $custid = $inputs['custid'];
        $buildid= $inputs['buildid'];
        $classname1 = $inputs['classname1'];
        $tag2=$inputs['tag2'];
        if($tag2<>2){///判断客户端上传审核状态是否存在， 2：全部。
            $where['Tag2'] = $tag2;
        }
        if($pdateS&&$pdateE){//判断客户端上传时间段参数是否存在
            $whereBetween[0] = $pdateS;
            $whereBetween[1] = $pdateE;
        }else{
            $date_now = date('Y-m-d');
            $whereBetween[0] = $date_now . ' 00:00:00';
            $whereBetween[1] = $date_now . ' 23:59:59';
        }
        if($searchtxt){ //判断客户端上传的搜索字符串
            $where['ProjectName|CustName|PlanID']= ['like','%'.$searchtxt.'%'];
            $whereGroup['ProjectName|CustName|PlanID']= ['like','%'.$searchtxt.'%'];
        }

        if($state<>9){ //判断客户端上传计划单状态是否存在， 9：全部。
            $where['ExecState'] = $state;
        }

        if($custid){ //判断是否上传客户代码
            $where['CustID'] = ['=',$custid];
        }

        if($buildid){ //判断是否上传客户代码
            $where['BuildID'] = ['=',$buildid];
        }

        if($classname1){ //判断是否上传业务员
            $where['ClassName1'] = $classname1;
        }

        $pageMpplans = MpplanModel::getMostRecent($size, $page, $where, $whereBetween);
        $summary = MpplanModel::getSummary( $where, $whereBetween);
        $summaryGroup  = MsaleoddModel::getSummaryGroup($whereGroup, $whereBetween);
        if ($pageMpplans->isEmpty()) {
            return [
                'current_page' => $pageMpplans->currentPage(),
                'last_page' => 0,
                'total_count' => $pageMpplans->total(),
                'total_qualityPlan' => 0,
                'total_qualityGive' => 0,
                'total_carNum' => 0,
                'total_qualityWS' => 0,
                'group_data'=> [],
                'data' => []
            ];
        }

        $data = $pageMpplans->getCollection()
            ->toArray();
        return [
            'current_page' => $pageMpplans->currentPage(),
            'last_page' => $pageMpplans->lastPage(),
            'total_count' => $pageMpplans->total(),
            'total_qualityPlan' => $summary['total_qualityPlan'],
            'total_qualityGive' => $summary['total_qualityGive'],
            'total_carNum' => $summary['total_carNum'],
            'total_qualityWS' => $summary['total_qualityWS'],
            'group_data' => $summaryGroup,
            'data' => $data
        ];
    }

    /**
     * 根据计划单号查询计划单
     * @param $id       计划单号
     * @return \think\response\Json
     * @throws MpplanException
     */
    public static function getOne($id)
    {
        $mpplan = MpplanModel::get(['PlanID'=>$id]);
        if (!$mpplan) {
            throw new MpplanException();
        }

        return json($mpplan);
    }


    //财务审核/反审核
    public static function setSH($id, $flag,$userName){

        $result = MpplanModel::upSHTag($id,$flag,$userName);
        return  $result;
    }

}