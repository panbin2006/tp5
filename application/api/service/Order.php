<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020-07-09
 * Time: 15:13
 */

namespace app\api\service;
use app\api\model\Mpactm as MpactmModel;
use app\api\model\Mcustomer as McustomerModel;
use app\api\model\Mpplancust as MpplancustModel;

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
        $this->order = $order;
        $this->mpactm =  MpactmModel::where('ProjectID', '=', $projectId)
//            ->fetchSql(true)
            ->find();
//        $id = $mpactDetil->ProjectID;
//        $tld = $order['tld'];
//        $str = 'CoID';
//        $coid = $mpactDetil->$str;
        $this->paddOrder();
        return 'projectid';
        $order->ProjectID = $mpact->ProjectID;
        $order->CoID = $mpact->CoID;
        $order->ProjectName = $mpact->ProjectName;
        $order->ProjectShort = $mpact->ProjectShort;
        $order->CustID = $mpact->CustID;
        $order->CustName = $mpact->CustName;
        $order->BuildID = $mpact->BuildID;
        $order->BuildName = $mpact->BuildName;
        $order->Address = $mpact->Address;
        $order->Space = $mpact->Space;
        $order->HTBH = $mpact->HTBH;
        $order->LinkMan = $mpact->Linkman1;
        $order->QualityMode = $mpact->QualityMode;
        $order->StyleMode = $mpact->StyleMode;
        $order->QualityOrder = $mpact->QualityOrder;
        $order->QualityOver = $mpact->QualityOver;
        $order->HideTag = $mpact->HideTag;
        $order->ClassID1 = $mpact->ClassID1;
        $order->ClassName1 = $mpact->ClassName1;
        $order->ClassName5 = $mpact->ClassName5;
        $order->PriceID = $mpact->PriceID;
        $order->Rate = $mpact->Rate;
        $order->PriceDown = $mpact->PriceDown;
        $order->HideTagB = $mpact->HideTagB;
        $order->HideTagC = $mpact->HideTagC;
        $order->HideTagD = $mpact->HideTagD;
        $order->HideTagE = $mpact->HideTagE;
        $order->MoneyMode = $mpact->MoneyMode;
        $order->Area = $mpact->Area;
        $order->Remark1 = $mpact->Remark1;
        $order->Remark2 = $mpact->Remark2;
        $order->Remark3 = $mpact->Remark3;
        $order->Remark4 = $mpact->Remark4;
        $order->SaleTag = $mpact->SaleTag;
        $order->SaleCOID = $mpact->SaleCOID;
        $order->SRemark1 = $mpact->SRemark1;
        $order->SRemark2 = $mpact->SRemark2;
        $order->SRemark3 = $mpact->SRemark3;
        $order->SRemark4 = $mpact->SRemark4;
        $order->FRemark1 = $mpact->FRemark1;
        $order->FRemark2 = $mpact->FRemark2;
        $order->FRemark3 = $mpact->FRemark3;
    }

    //把合同信息加到订单中
    private function paddOrder(){
        //订单要从合同读取的字段名数组
        $orderArr = ['ProjectID',
		'CoID',
		'ProjectName',
		'ProjectShort',
		'CustID',
		'CustName ',
		'BuildID',
		'BuildName',
		'Address',
		'Space',
		'HTBH',
		'LinkMan',
		'QualityMode',
		'StyleMode',
		'QualityOrder',
		'QualityOver',
		'HideTag',
		'ClassID1',
		'ClassName1',
		'ClassName5',
		'PriceID',
		'Rate',
		'PriceDown',
		'HideTagB',
		'HideTagC',
		'HideTagD',
		'HideTagE ',
		'MoneyMode',
		'Area',
		'Remark1',
		'Remark2',
		'Remark3',
		'Remark4',
		'SaleTag',
		'SaleCOID',
		'SRemark1',
		'SRemark2',
		'SRemark3',
		'SRemark4',
		'FRemark1',
		'FRemark2',
		'FRemark3'
	    ];
    }
}