<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/25
 * Time: 15:49
 */

namespace app\api\controller\v1;


use app\api\validate\Count;
use app\api\validate\PageNumberMustBePositiveInt;
use app\api\model\Matin as MatinModel;

class Matin
{
    public static function getRecent($size=15, $page=2, $pdateS, $pdateE, $name=''){

        (new Count())->goCheck($size);
        (new PageNumberMustBePositiveInt())->goCheck($page);
        $pageMatins = MatinModel::getMostRecent($size, $page, $pdateS, $pdateE, $name);
        $summary = MatinModel::getSummary($size, $page, $pdateS, $pdateE, $name);

        if($pageMatins->isEmpty()){
            return [
                'current_page' => $pageMatins->currentPage(),
                'total_count' => $pageMatins->total(),
                'total_quality' => $summary['total_quality'],
                'data' => []
            ];
        }

        $data = $pageMatins->getCollection()
            ->toArray();

        return [
            'current_page' => $pageMatins->currentPage(),
            'total_count' => $pageMatins->total(),
            'total_quality' => $summary['total_quality'],
            'data' => $data
        ];

    }
}