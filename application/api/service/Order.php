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
    public function place($uid,$mpactm,$orderDetail){
        //客户名称
        $custNmae = $mpactm['custname'];
        //工程名称
        $projectName = $mpactm['projectname'];

        //1、查询客户名称是否存在；如果存在该客户名称直接用原客户信息,不存在创建新的客户,并返回客户信息
        $cust = Mcustomer::getMcustomerByCustName($custNmae);
        if(!$cust){//不存在客户
            //创建客户资料
            //创建新合同
            //保存订单
            return;
        }

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
//            ->fetchSql(true)
            ->find();
        //读取合同信息到订单
        $this->paddOrder();
        //生成订货单编号
        $planId = $this->getCode();
        $this->order['PlanID'] = $planId;
        $this->order['PlanName'] = $planId;
        //生成计划生产线字段
        $pline = $this->getPlines();
        $this->order['Pline'] = $pline;
        //读取系统默认值
        $this->getDefault();

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

    //生成订货单编号
    private function getCode(){
        $id = CodeService::getCode('Mpplancust',$this->order['CoID'],1,'2020-07-15','');
        $planId = $id[0]['codeid'];
        return $planId;
    }

    //读取系统默认值
    private function getDefault(){
        $arr = [];
        $default = Tscolumns::where('TblID','=','MPPlanCust')
            ->select(['ShaRate1','ShaRate2','SZRate1','SZRate2','SNStyle','SZStyle','WJJStyle','']);
        foreach ($default as $item){
            $key = $item['ColsID'];
            $value = $item['iniValue'];
            echo  $key.':'.$value.'<br>';
            $this->order[$key] = $value;
        }
        return $default;
    }
}