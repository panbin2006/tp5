<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020/1/7
 * Time: 8:56
 */

namespace app\api\service;

use app\api\model\Matstorem as MatstoremModel;
use app\api\model\Tmpcwiostat2 as Tmpcwiostat2Model;
use app\api\model\Tmpcwiostat2;
use think\Db;

class Matstoreiostat
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
     * 执行存储过程sp_MatCWIOStat生成库存到tmpCWIOStat表，返回库存信息
     *
     * @param $params  array  储存过程参数
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getMatstoreiostat( )
    {

        $this->getParamsStr();

        Db::startTrans();

        try {

            //这里特别注意，执行存储过程有返回值的有Db::query,没有返回值的用Db::execute,
            //不然会报错：SQLSTATE[IMSSP]: The active result for the query contains no fields.
            Db::execute($this->sql);
            Db::execute("exec sp_MatStoreStatT 'MatStoreStat'");
            // 提交事务
            $tmpcwiostat = Tmpcwiostat2Model:: getMatStoreiostatRecent();
            Db::commit();
            return $tmpcwiostat;

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

        if (!array_key_exists('Bdate', $this->params)) {
            $Bdate = ['Bdate' => $this->getBdate()];
            $this->params = array_merge($Bdate, $this->params);
        }

        $produce = "exec sp_MatStoreStat  '";
        $paramsStr = implode("','", $this->params) . "'";
        $this->sql = $produce . $paramsStr;

    }

}