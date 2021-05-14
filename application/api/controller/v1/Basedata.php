<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/12
 * Time: 17:00
 */

namespace app\api\controller\v1;


use app\api\model\Barea ;
use app\api\model\Bcoclass1;
use app\api\model\Bcoclass2;
use app\api\model\Bcoclass5;
use app\api\model\Bbtld;
use app\api\model\Bexecstate;
use app\api\model\Bplanstate;
use app\api\model\Bpline;
use app\api\model\Mbetoninfo;
use app\api\model\Bbtrans;
use app\api\model\Scobm;

//获取基础表数据，坍落度、施工方式、区域、业务员、结款类型等
class Basedata
{
    protected $baseDate;
    public  function getBasedata()
    {
        $inputs  = input('post.');
        $tbls = $inputs['tables'];
        $baseData  =[];
        foreach ($tbls as $tbl){
            //拼接方法名字符串
            $action ='get'.$tbl;
            //通过字符串名调用方法
            $baseData[$tbl] =$this-> {$action}();
        }
        return $baseData;

    }

    private static function getArea()
    {
        $result = Barea::all();
        return $result;
    }

    private static function getBcoclass1()
    {
        $result = Bcoclass1::all();
        return $result;
    }

    private static function getBcoclass2()
    {
        $result = Bcoclass2::all();
        return $result;
    }

    private static function getBcoclass5()
    {
        $result = Bcoclass5::all();
        return $result;
    }

    private static function getBbtld()
    {
        $result = Bbtld::all();
        return $result;
    }

    private static function getMbetoninfo()
    {
        $result = Mbetoninfo::all();
        return $result;
    }

    private static function getBbtrans()
    {
        $result = Bbtrans::all();
        return $result;
    }

    private static function getScobm(){
        $result = Scobm::all();
        return $result;
    }

    private static function getBexecstate(){
        $result = Bexecstate::all();
        $result->unshift(['ExecState'=>'全部']);
        return $result;
    }
    private static function getBplanstate(){
        $result = Bplanstate::all();
        $result->unshift(['ExecState'=>'9','StateDesc'=>'全部']);
        return $result;
    }
    private static function getBPline(){
        $result = Bpline::field(['Pline'])
        ->select();
        $result->append(['PlineName'])
        ->unshift(['Pline'=>'0','PlineName'=>'全部']);
        return $result;
    }
}