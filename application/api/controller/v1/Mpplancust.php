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
use app\lib\exception\SuccessMessage;
use app\api\service\Order as OrderService;

class Mpplancust
{

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
        $mpatm = MpplancustModel::getMpactmDetail($id);
        if(!$mpatm){
            throw new MpactmException();
        }
        return json($mpatm);
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
    public function  getInfoByState($size=15, $page=1,$state=''){
        (new Count())->goCheck($size);
        (new PageNumberMustBePositiveInt())->goCheck($page);
        $pageMpplancusts = MpplancustModel::getInfoByExecState($size, $page, $state);

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
    public  function  setSH($id, $flag){
        $result = MpplancustModel::upShTag($id, $flag);
        return  $result;
    }


    /**
     * 修改订货单执行状态
     * @param $id  string   工程代码
     * @param $state  string  执行状态
     *
     */

    public  function  setState($id, $state){
        (new PlanStatusEnum())->goCheck($state);
        $result = MpplancustModel::upState($id, $state);
        return $result;
    }

    /**
     * 新增/修改订单
     * @return \think\response\Json
     */
    public static function edit(){
        $inputs  = input('post.');
        $mpactLock = $inputs['mpactLock'];
        $order = $inputs['order'];
        $mpact = $inputs['mpact'];
        $projectId = $mpact['ProjectID'];
        $orderService = new OrderService();
        if($mpactLock){
            $result =  $orderService->save($projectId,$order);
//            return 'oldPact';
//            return $mpact['ProjectID'];
        }else{
//            self::createOrder($inputs);
            return 'newPact';
        }

        return $result;
    }

    /**
     * 新增/修改订单
     * @return \think\response\Json
     */
    private static function save($inputs){
        return '123';
//        $data = $inputs['data'];
//        $where = $inputs['where'];
//
//        $cust = MpplancustModel::get($where);
//        if(empty($cust)){
//            $result = MpplancustModel::create($data);
//            //$result = MpplancustModel::create(array_merge($data, $where));
//        }else{
//            //数据库表更新触发器问题，TriTag必须与原记录的值不一样，这样才不会触发更新触发器
//            //不然数据更新失败
//            $data['TrigTag'] = $cust->TrigTag +1;
//            $result = MpplancustModel::update($data, $where);
//        }


        return json(new SuccessMessage(['msg' => $result]), 201);
    }


    /*
     *
     * 使用orderService创建订单
     */

    private function createOrder(){
        $inputs  = input('post.');
        $uid = $inputs['uid'];
        $mpactm = $inputs['mpactm'];
        $orderDetail = $inputs['orderDetail'];
        $orderService = new Order();
        $result = $orderService->place($uid, $mpactm, $orderDetail);
        return $result;
    }
}