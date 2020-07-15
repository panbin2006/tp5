<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020-07-09
 * Time: 15:13
 */

namespace app\api\service;
use app\api\model\Bpline;
use app\api\model\Mpactm as MpactmModel;
use app\api\model\Mcustomer as McustomerModel;
use app\api\model\Mpplancust as MpplancustModel;
use app\api\model\Tscolumns;
use app\api\service\Code as CodeService;
use app\lib\exception\SuccessMessage;
use app\api\service\Tscolumns as TscolumnsService;
use app\api\service\Custmoter as CustmoterService;
use app\api\service\Mpact as MpactService;

class Order
{
    //工程合同，也就是客户端传过来的合同信息
    protected $mpactm;

    //客户资料
    protected  $customer;

    //订单详细信息,客户端传过来的订单信息(混凝土规格、开盘时间、备注等)
    protected $orderDetail;

    //完整的订单信息(合同信息 + 订单详细信息)
    protected $order;

    protected  $uid;

    //下达订单
    public function place($mpactm,$order){
        $this->order = $order;
        //客户名称
        $custNmae = $mpactm['CustName'];
        //工程名称
        $projectName = $mpactm['ProjectName'];

        //1、查询客户名称是否存在；如果存在该客户名称直接用原客户信息,不存在创建新的客户,并返回客户信息
        $this->customer = CustmoterService::hasCust($custNmae);
        return $this->customer;

        $this->mpactm = MpplancustModel::create($this->customer);

        //2、查询工程名称是否存在：如果存在该工程名称并且客户名称也与原合同中的一致，直接用原合同信息；否则创建新的合同
        $project= Mpactm::getMpactByProjName($projectName);
        if(!$projectName){ //不存在合同
                //判断合同中的客户名称与客户端传入的客户名称是否一致
                if($custNmae == $project->ProjectName){
                    //使用客户端传入的客户信息
                }else{
                    //创建新的客户
                }
                //创建新合同
                //保存订单
        }

        //3、根据合同信息、订单信息生成完整的订单信息
        //4、保存订单
    }

    //现有合同下单
    public  function save($projectId, $order){
        //读取订单信息
        $this->order = $order;
        $this->mpactm =  MpactmModel::where('ProjectID', '=', $projectId)

            ->find();

        //读取合同信息到订单
        $this->paddOrder();

        //生成订货单编号
       // $planId = $this->getCode();
        $planId = Code::getCode('Mpplancust',$this->order['CoID'],1,'2020-07-15','');
        $this->order['PlanID'] = $planId;
        $this->order['PlanName'] = $planId;

        //生成计划生产线字段
        $pline = $this->getPlines();
        $this->order['Pline'] = $pline;

        //读取系统默认值
        $defaultFields = ['ShaRate1','ShaRate2','SZRate1','SZRate2','SNStyle','SZStyle','WJJStyle',''];
//        $this->getDefault('MPPlanCust',$defaultFields,$this->order);
        $this->order =  TscolumnsService::getDefault('MPPlanCust',$defaultFields,$this->order);
        //保存订单
        $result = MpplancustModel::create($this->order);

        if($result){
            return json(new SuccessMessage(['msg' => $result]), 201);
        }else{
            return json(new SuccessMessage(['msg'=> []]), 40000);
        }

    }

    //把合同信息加到订单中
    private function paddOrder(){
        //订单要从合同读取的字段名数组
        $orderArr = ['ProjectID', 'CoID', 'ProjectName', 'ProjectShort', 'CustID', 'CustName', 'BuildId', 'BuildName', 'Address', 'Space',
		'HTBH', 'LinkMan', 'QualityMode', 'StyleMode', 'QualityOrder', 'QualityOver', 'HideTag', 'ClassID1', 'ClassName1', 'ClassName5',
		'PriceID', 'Rate', 'PriceDown', 'HideTagB', 'HideTagC', 'HideTagD', 'HideTagE', 'MoneyMode', 'Area', 'Remark1', 'Remark2', 'Remark3', 'Remark4', 'SaleTag', 'SaleCoID',
		'SRemark1', 'SRemark2', 'SRemark3', 'SRemark4', 'FRemark1', 'FRemark2', 'FRemark3'];
        foreach ($orderArr as $field){
            if($field == 'LinkMan'){
                $this->order[$field] = $this->mpactm['Linkman1'];
            }else{
                $this->order[$field] = $this->mpactm[$field];
            }
        }
    }

    //获取生产线列表
    private function getPlines(){

        $plines = Bpline::getMostRecent();
        $plinesStr = '';
        foreach ($plines as $pline){
            $plinesStr .=  $pline['Pline'] .',';
        }
        $plinesStr = substr($plinesStr,0,strlen($plinesStr)-1);
        return $plinesStr;
    }


    //读取系统默认值
    private function getDefault($tblId,$defaultFields,$obj){
        $arr = [];
        $default = Tscolumns::where('TblID','=',$tblId)
            ->select($defaultFields);
        foreach ($default as $item){
            $key = $item['ColsID'];
            $value = $item['iniValue'];
            echo  $key.':'.$value.'<br>';
            $obj[$key] = $value;
        }
        return $default;
    }
}