<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020-07-09
 * Time: 15:13
 */

namespace app\api\service;
use app\api\model\Mpactm;
use app\api\model\Mcustomer;
use app\api\model\Mpplancust;

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
}