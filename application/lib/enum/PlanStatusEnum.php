<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/12
 * Time: 16:50
 */

namespace app\lib\enum;


class PlanStatusEnum
{
    //全部
    const ALL = 9;

    //开工
    const EXECUTE = 0;

    //等待
    const WAITING = 1;

    //完工
    const COMPLETE = 2;
}