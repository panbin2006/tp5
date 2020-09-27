<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/11/12
 * Time: 10:34
 */

namespace app\api\model;


use think\Model;
use think\Request;

class Syhqx extends Model
{
    protected $pk = ['YHID','CoID'];
    protected $hidden = ['BMID','ROW_NUMBER','Iden_id','PriceTag','PlanTag','LabTag','CoIDTag','YHIDT','SHMan','SHTag','SHTagA',
        'SHTime','GZMan','GZTag','GZTagA','GZTime','HideTag','HideEditTag','Tag1','Tag2','Tag3','HideTagB','HideTagC','HideTagD',
        'HideTagE','HideEditTagB','HideEditTagC','HideEditTagD','HideEditTagE','TrigTag','ZhiChen','UserInNum','PhbViewBZ','PhbViewSG'];
    public static function getUserById($id) {
        $user = self::where('Iden_id', '=', $id)
            ->find();
        return $user;
    }

    public static function getUserByYhid($id) {
        $user = self::where('YHID', '=', $id)
            ->find();
        return $user;
    }

    public static  function getUserByOpenid($openid) {
        $user = self::where('Remark1', '=', $openid)
            ->find();
        return $user;
    }

    public static function  checkUser($params){
        $user = self::where('bmid', '=', $params['bmid'])
            ->where('yhid', '=', $params['yhid'])
            ->where('pwd', '=', $params['pwd'])
            ->find();
        return $user;
    }

    public static function  checkSaleman($where){
        $user = self::where($where)
            ->fetchSql(false)
            ->find();
        return $user;
    }

}