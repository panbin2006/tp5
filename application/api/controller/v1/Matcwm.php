<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020/1/4
 * Time: 14:40
 */

namespace app\api\controller\v1;


use app\api\model\Matcwm as MatcheckmModel;
use app\lib\exception\MatcwmException;

class Matcwm
{
    public function getRecent($pdateS, $pdateE, $size=3, $page=1){
        $pageMatcheckms = MatcheckmModel::getMostRecent($pdateS, $pdateE, $size, $page);

//        return $pageMatcheckms;
        if($pageMatcheckms->isEmpty()){
            throw new MatcwmException();
        }

        return $pageMatcheckms;
    }


}