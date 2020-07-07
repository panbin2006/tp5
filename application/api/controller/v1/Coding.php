<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020-07-07
 * Time: 15:02
 */

namespace app\api\controller\v1;


use think\Db;

class Coding
{
    /**
 *单据代码生成
 *
 * @return \think\Response
 */
    public function getCode($ModuleID,$CoID,$IsUpdate ,$PDate ,$PType=' ')
    {

        // thinkphp调用存储过程(所有语句要全部连接起来，一起提交执行，不然会报错)
        $sql_declare="declare  @CodeID varchar(20) ";
        $sql_code='select @CodeID as codeid;';
        $sql = $sql_declare."exec GetCodeID  '".$ModuleID."' , '".$CoID."' ,".$IsUpdate." ,'".$PDate."' ,'".$PType."' ,"." @CodeID output;".$sql_code;
        $CodeID = Db::query($sql);
        return json_encode($CodeID);

    }
}