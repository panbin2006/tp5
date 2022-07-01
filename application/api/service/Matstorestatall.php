<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020/1/7
 * Time: 8:56
 */

namespace app\api\service;

use app\api\model\Tmpmatstorenow as TmpMatStoreNowModel;
use think\Db;

class Matstorestatall
{
    //存储过程sql字符串
    protected $sql;

    //存储过程参数
    protected $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * exec sp_MatStoreNowAll '2022-06-30 15:34:41','01','DateIn','0','PDate','','粉仓'
     * 执行存储过程sp_MatStoreNowAll生成库存到tmpMatStoreNow表，返回库存信息
     *
     * @param $params  array  储存过程参数
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getMatstoreiostat( )
    {
        //拼接sql语句
        $this->getParamsStr();

        Db::startTrans();

        try {

            //这里特别注意，执行存储过程有返回值的用Db::query,没有返回值的用Db::execute,
            //不然会报错：SQLSTATE[IMSSP]: The active result for the query contains no fields.
            Db::execute($this->sql);
            $tmpStoreStatNow = TmpMatStoreNowModel::getMatStoreiostatRecent();
           //  提交事务
            Db::commit();
            return $tmpStoreStatNow;

        } catch (\Exception $e) {

            // 回滚事务
            Db::rollback();
        }
    }


    /**
     * 查询最后一次盘点时间
     * @return bool|string
     */
    public function getBdate()
    {
        $Bdate = MatstoremModel::getLastPdate();
        return substr($Bdate['Pdate'], 0, 19);
    }


    /**
     * 拼接sql字符串
     * @param $params
     * @return string
     */
    public function getParamsStr()
    {

        //判断参数列表中是否存在库存查询截止时间Edate,如果没有，取当前时间
        if (!array_key_exists('Edate', $this->params)) {
            $Edate = ['Edate' =>  date('Y-m-d H:i:s',time())];
            $this->params = array_merge($Edate, $this->params);
        }

        $produce = "exec sp_MatStoreNowAll   '";
        $paramsStr = implode("','", $this->params) . "'";
        $this->sql = $produce . $paramsStr;

    }

}