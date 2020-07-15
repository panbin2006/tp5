<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020-07-09
 * Time: 15:10
 */

namespace app\api\service;


use think\Db;

class Code
{
    public static function getCode($ModuleID,$CoID,$IsUpdate ,$PDate ,$PType=' ')
    {

        // thinkphp调用存储过程(所有语句要全部连接起来，一起提交执行，不然会报错)
        $sql_declare="declare  @CodeID varchar(20) ";
        $sql_code='select @CodeID as codeid;';
        $sql = $sql_declare."exec GetCodeID  '".$ModuleID."' , '".$CoID."' ,".$IsUpdate." ,'".$PDate."' ,'".$PType."' ,"." @CodeID output;".$sql_code;
        $CodeID = Db::query($sql);
        $CodeID = $CodeID[0]['codeid'];
        return $CodeID;
    }
}