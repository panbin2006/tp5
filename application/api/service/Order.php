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
use app\api\model\Mpplancust as MpplancustModel;
use app\lib\exception\SuccessMessage;
use app\api\service\Tscolumns as TscolumnsService;
use app\api\service\Custmoter as CustmoterService;
use app\api\service\Mpact as MpactService;
use app\api\service\Code as CodeService;
use think\Db;
use think\Exception;

class Order
{
    //工程合同，也就是客户端传过来的合同信息
    protected $mpactm;
    //客户资料
    protected  $customer;
    //完整的订单信息(合同信息 + 订单详细信息)
    protected $order;
    //用户id
    protected  $uid;
    //分站代码
    protected  $coid;
    //计划日期
    protected  $pDate;

    //新合同下单
    public function newMpact_place($mpactm,$order){
        //接收客户端上传的合同与订单信息
        $this->order = $order;
        $this->mpactm = $mpactm;
        //客户名称
        $custNmae = $mpactm['CustName'];
        $this->coid = $mpactm['CoID'];
        $this->pDate = $order['PDate'];

        //查询客户名称是否存在；如果存在该客户名称直接用原客户信息,不存在创建新的客户,并返回客户信息
        $this->customer = CustmoterService::hasCust($custNmae,$this->coid);
        //创建合同
        $this->mpactm = MpactService::create($this->mpactm,$this->customer);

        //工程代码
        $projectId = $this->mpactm['ProjectID'];
        //根据工程代码，读取完整的合同信息。create方法返回的字段不完整，这里需要重新读取，否则字段映射会出错
        $this->mpactm =  MpactmModel::where('ProjectID', '=', $projectId)
                ->find();
        $result = $this->save();
        return $result;

    }

    //现有合同下单
    public function  oldMpact_place($mpactm,$order){
        //接收客户端上传的合同与订单信息
        $this->order = $order;
        $this->mpactm = $mpactm;
        $this->coid = $mpactm['CoID'];
        $this->pDate = $order['PDate'];
        $address = $mpactm['Address']; //接收用户标定的地址

        //工程代码
        $projectId = $this->mpactm['ProjectID'];

        //根据工程代码，读取完整的合同信息
        $this->mpactm =  MpactmModel::where('ProjectID', '=', $projectId)
            ->find();
        if($address != $this->mpactm['Address']){ //判断客户端提交的地址与合同中返回的地址是否相同，如果不同；更新合同中的地址'

            $this->mpactm['Address'] = $address;
            $this->mpactm->save();
        }
        $result = $this->save();
        return $result;

    }

    //保存订单
    private  function save(){
        //把合同信息加到订单对象中
        $this->paddOrder();

        //生成订货单编号
        $orderid = CodeService::getCode('Mpplancust',$this->coid,1,$this->pDate,'');
        $this->order['OrderID'] = $orderid;

        //生成计划生产线字段
//        $pline = $this->getPlines();
//        $this->order['Pline'] = $pline;

        //读取系统默认值
        //$defaultFields = ['ShaRate1','ShaRate2','SZRate1','SZRate2','SNStyle','SZStyle','WJJStyle',''];
        //$this->order =  TscolumnsService::getDefault('MPPlanCust',$defaultFields,$this->order);
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
		'HideTagB', 'HideTagC', 'HideTagD', 'HideTagE', 'MoneyMode', 'Area', 'Remark1', 'Remark2', 'Remark3', 'Remark4',
		'SRemark1', 'SRemark2', 'SRemark3', 'SRemark4', 'FRemark1', 'FRemark2', 'FRemark3','ClassID2','ClassName2','TransID','MoneyMode'];
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

}