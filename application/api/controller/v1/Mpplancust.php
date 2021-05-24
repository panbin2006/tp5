<?php
/**
 * Created by PhpStorm->
 * User: panbin
 * Date: 2019/11/25
 * Time: 11:07
 */

namespace app\api\controller\v1;

use app\api\validate\Count;
use app\api\model\Mpplancust as MpplancustModel;
use app\api\validate\PageNumberMustBePositiveInt;
use app\lib\enum\PlanStatusEnum as PlanStatusEnum;
use app\lib\exception\MpplancustException;
use app\lib\exception\SuccessMessage;
use app\api\service\Order as OrderService;

class Mpplancust
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
    public static function getRecentWhere($size=15, $page=1)
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
        $orderType = $inputs['orderType'];
        $custid = $inputs['custid'];
        $buildid = $inputs['buildid'];
        $classname1 = $inputs['classname1'];
        $importTag = $inputs['importtag'];

        if($importTag<>9){ //判断客户端上传导入状态是否存在，0：未导入；1：已导入； 9：全部。
            $where['ImportTag'] = $importTag;
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
            $where['ProjectName|CustName|PlanName']= ['like','%'.$searchtxt.'%'];
            $whereGroup['ProjectName|CustName|PlanName']= ['like','%'.$searchtxt.'%'];
        }
        if($orderType){
            $where['OrderType'] =['=' , $orderType];
        }

        if($custid){ //判断是否上传客户代码
            $where['CustID'] = ['=',$custid];
        }

        if($buildid){ //判断是否上传施工单位代码
            $where['BuildID'] = ['=',$buildid];
        }
        if($classname1){ //判断是否上传业务员
            $where['ClassName1'] = $classname1;
        }

        $pageMpplancusts= MpplancustModel::getMostRecentWhere($size, $page, $where, $whereBetween);
        $summary = MpplancustModel::getSummaryWhere( $where, $whereBetween);

        if ($pageMpplancusts->isEmpty()) {
            return [
                'current_page' => $pageMpplancusts->currentPage(),
                'hasPages' =>  $pageMpplancusts->hasPages(),
                'total' => 0,
                'total_qualityPlan' => 0,
                'total_count' => 0,
                'data' => []
            ];
        }

        $data = $pageMpplancusts->getCollection()
            ->toArray();
        return [
            'current_page' => $pageMpplancusts->currentPage(),
            'total' => $pageMpplancusts->total(),
            'total_qualityPlan' => $summary->total_qualityPlan,
            'total_count' => $summary->total_count,
            'hasPages' =>  $pageMpplancusts->hasPages(),
            'data' => $data
        ];
    }

    /**
     * 分页查询订货单
     * @url  /mpactm/recent
     * @http  GET
     * $size  int 每页记录数
     * $page  int 当前页码
     */



    public  function  getRecent($size=15, $page=1){
        (new Count())->goCheck($size);
        (new PageNumberMustBePositiveInt())->goCheck($page);
        $pageMpplancusts = MpplancustModel::getMostRecent($size, $page);
          if ($pageMpplancusts->isEmpty()){
            return [
                'current_page' => $pageMpplancusts->currentPage(),
                'hasPages' =>  $pageMpplancusts->hasPages(),
                'total' => 0,
                'data' => []
            ];
        }
        $data  = $pageMpplancusts->getCollection()
        ->toArray();

        return [
            'current_page' => $pageMpplancusts->currentPage(),
            'total' => $pageMpplancusts->total(),
            'hasPages' =>  $pageMpplancusts->hasPages(),
            'data' => $data
        ];
    }

    /**
     *
     * 获取指定订单号信息
     * @url  /mpactm/:id
     * @http  GET
     * @param $id  工程代码
     * @return \think\response\Json
     * @throws MpactmException
     */
    public  function  getOne($id){
        $mpplancust = MpplancustModel::get(['OrderID'=>$id]);
        if(!$mpplancust){
            throw new MpplancustException();
        }
        return json($mpplancust);
    }

    /**
     * 根据客户名称或者工程名称模糊查询
     * @url /mpact/by_name
     * @http  GET
     *  $size  int 每页显示的记录数
     * $page  int 页码
     * $name  string 过滤字段
     *
     **/
    public function  getInfoByName($size=15, $page=1,$name=''){
        (new Count())->goCheck($size);
        (new PageNumberMustBePositiveInt())->goCheck($page);
        $pageMpplancusts = MpplancustModel::getInfoByName($size, $page, $name);
//        return $pageMpplancusts;
        if($pageMpplancusts->isEmpty()){
            return [
                'current_page' => $pageMpplancusts->currentPage(),
                'total' => $pageMpplancusts->total(),
                'hasPages' =>  $pageMpplancusts->hasPages(),
                'data' => []
            ];
        }

        $data = $pageMpplancusts->getCollection()
            ->toArray();
        return [
            'current_page' => $pageMpplancusts->currentPage(),
            'total' => $pageMpplancusts->total(),
            'hasPages' =>  $pageMpplancusts->hasPages(),
            'data' => $data
        ];
    }

    /**
     * 根据订单执行状态查询
     * @url /mpact/by_name
     * @http  GET
     *  $size  int 每页显示的记录数
     * $page  int 页码
     * $state string 过滤字段
     *
     **/
    public function  getInfoByOrderType($size=15, $page=1,$OrderType=''){
        (new Count())->goCheck($size);
        (new PageNumberMustBePositiveInt())->goCheck($page);
        $pageMpplancusts = MpplancustModel::getInfoByExecState($size, $page, $OrderType);

        if($pageMpplancusts->isEmpty()){
            return [
                'current_page' => $pageMpplancusts->currentPage(),
                'total' => $pageMpplancusts->total(),
                'hasPages' =>  $pageMpplancusts->hasPages(),
                'data' => []
            ];
        }

        $data = $pageMpplancusts->getCollection()
            ->toArray();
        return [
            'current_page' => $pageMpplancusts->currentPage(),
            'total' => $pageMpplancusts->total(),
            'hasPages' =>  $pageMpplancusts->hasPages(),
            'data' => $data
        ];
    }

    /**
     * 修改订货单审核标志
     * @param $id  string   工程代码
     * @param $flag bool    审核标志
     *
     */
    public  function  setSH($orderID, $flag){
        $result = MpplancustModel::upShTag($orderID, $flag);
        return  $result;
    }


    /**
     * 修改订货单执行状态
     * @param $id  string   工程代码
     * @param $state  string  执行状态
     *
     */

    public  function  setState($orderID, $state){
        (new PlanStatusEnum())->goCheck($state);
        $result = MpplancustModel::upState($orderID, $state);
        return $result;
    }

    /**
     * 新增订单
     * @return \think\response\Json
     */
    public static function edit(){
        $inputs  = input('post.');
        $mpactLock = $inputs['mpactLock'];
        $order = $inputs['order'];
        $mpact = $inputs['mpact'];

        $orderService = new OrderService();
        if($mpactLock){
            $result =  $orderService->oldMpact_place($mpact, $order);
        }else{

            $result = $orderService->newMpact_place($mpact, $order);
        }

        return $result;
    }

    /**
     * 复制新增订单
     * @return \think\response\Json
     */
    public static function copyNew(){
        $inputs  = input('post.');
        $copyOrder = $inputs['order'];

        $orderService = new OrderService();
        $result =  $orderService->copyNew($copyOrder);
        return $result;
    }

    //修改订单
    public static function modify(){
        $inputs  = input('post.');
        $orderid = $inputs['orderid'];
        $order = $inputs['order'];

        $mpplancust = MpplancustModel::get(['OrderID'=>$orderid]);
        if(!$mpplancust){
            throw new MpplancustException();
        }
        $result = $mpplancust->update($order,['OrderID'=>$orderid]);

        return $result;
    }
}