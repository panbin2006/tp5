<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/24
 * Time: 15:41
 */

namespace app\api\controller\v1;


use app\api\validate\Count;
use app\api\validate\PageNumberMustBePositiveInt;
use app\api\model\Mproductrecm as MproductrecmModel;
use app\lib\exception\MproductrecmException;

class Mproductrecm
{
    /**
     * 查询生产记录分页信息
     * @url  /mproductrecm/recent
     * @param int $size  单页记录数
     * @param int $page  页码
     * @param $pdateS   开始时间
     * @param $pdateE   截止时间
     * @param string $name  工程名称/客户名称
     * @return array
     * @throws \app\lib\exception\ParameterException
     */
    public static function getRecent($size=15, $page=1){

        (new Count())->goCheck($size);
        (new PageNumberMustBePositiveInt())->goCheck($page);

        //获取查询条件
        $inputs = input('post.');
        $where = [];
        $whereBetween = [];

        $pdateS = $inputs['pdateS'];
        $pdateE = $inputs['pdateE'];
        $pline = $inputs['pline'];
        $custid = $inputs['custid'];
        $classname1 = $inputs['classname1'];
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
        if($custid){ //判断是否上传客户代码
            $where['CustID'] = ['=',$custid];
        }

        if($classname1){ //判断是否上传业务员
            $where['ClassName1'] = $classname1;
        }
        if($searchtxt){ //判断客户端上传的搜索字符串
            $where['ProjectName|CustName|PlanID']= ['like','%'.$searchtxt.'%'];
        }

        $pageMproductrecms = MproductrecmModel::getMostRecent($size, $page, $where, $whereBetween);
        $summary = MproductrecmModel::getSummary($where, $whereBetween);
        if($pageMproductrecms->isEmpty()){
            return [
                'current_page' => $pageMproductrecms->currentPage(),
                'last_page' => 0,
                'total_count' => $pageMproductrecms->total(),
                'total_quality' => 0,
                'data' => []
            ];
        }

        $data = $pageMproductrecms->getCollection()
            ->toArray();

        return [
            'current_page' => $pageMproductrecms->currentPage(),
            'last_page' => $pageMproductrecms->lastPage(),
            'total_count' => $pageMproductrecms->total(),
            'total_quality' => $summary['total_quality'],
            'data' => $data
        ];
    }

    /**
     * 根据生产记录号查询材料下料清单
     * @url    /mproductrecm/:id
     * @param $id
     * @return Array
     */
    public static function getOne($id){
        $total_verrs = 0;
        $mproductrecm = MproductrecmModel::getMproductrecmDetail($id);
        if(!$mproductrecm){
            throw  new MproductrecmException();
        }
        //查询材料消耗合计
        $result = \app\api\model\Mproductrecd::getSummary($id);

        //返回合计数据
        $total_mproductds = $result[0];
        //计算总误差率
        if($total_mproductds['total_vpf'] <> 0){
            $total_verrs = $total_mproductds['total_verr'] / $total_mproductds['total_vpf'] * 100;
        }

        //四舍五入，保留两位小数自动补0
        $total_mproductds['total_verrs'] = sprintf("%.2f", round($total_verrs,2));

        $mproductrecm['total_mproductds'] = $total_mproductds;
        return json($mproductrecm);
    }
}