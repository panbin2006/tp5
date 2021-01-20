<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/11
 * Time: 15:31
 */

namespace app\api\controller\v1;


use app\api\validate\Count;
use app\api\validate\PageNumberMustBePositiveInt;
use app\api\model\Msaleday as MsaledayModel;
class Msaleday
{

    /**
     * 查询分页数据
     * @url    api/v1/msaleday/recent'
     * @method  POST
     * @param int $size 单页记录数
     * @param int $page  页码
     * @return array
     * @throws \app\lib\exception\ParameterException
     */
    public  static  function getRecent($size=15, $page=1){

        (new Count())->goCheck($size);
        (new PageNumberMustBePositiveInt())->goCheck($page);

        //获取查询条件
        $inputs = input('post.');
        $where = [];
        $whereBetween = [];
        $pdateS = $inputs['pdateS'];
        $pdateE = $inputs['pdateE'];
        $searchtxt = $inputs['searchtxt'];
        $custid = $inputs['custid'];
        $buildid= $inputs['buildid'];
        $classname1 = $inputs['classname1'];

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

        if($custid){ //判断是否上传客户代码
            $where['CustID'] = ['=',$custid];
        }

        if($buildid){ //判断是否上传客户代码
            $where['BuildID'] = ['=',$buildid];
        }

        if($classname1){ //判断是否上传业务员
            $where['ClassName1'] = $classname1;
        }


        $pageMsaledays =  MsaledayModel::getMostRecent($size, $page,$where,$whereBetween);
        $summary = MsaledayModel::getSummary($where,$whereBetween);
        if($pageMsaledays->isEmpty()){
            return [
                'current_page' => $pageMsaledays->currentPage(),
                'last_page' => 0,
                'total_count' => $pageMsaledays->total(),
                'total_quality' => $summary['total_quality'],
                'total_transNum' => $summary['total_transNum'],
                'data' => []
            ];
        }

        $data = $pageMsaledays->getCollection();
           // ->toArray();
        return [
            'current_page' => $pageMsaledays->currentPage(),
            'last_page' => $pageMsaledays->lastPage(),
            'total_count' => $pageMsaledays->total(),
            'total_quality' => $summary['total_quality'],
            'total_transNum' => $summary['total_transNum'],
            'data' => $data
        ];
    }
}