<?php
namespace app\api\controller;

use think\Console;
use org\util\ArrayList;

class Index
{
    public function index()
    {
    	// 调用命令行的指令
    	// $output = Console::call('make:model', ['index/Blog']);
    	// return  $output->fetch();

    	$list       = ['thinkphp', 'thinkphp', 'onethink', 'topthink'];
    	$arrayList  = new ArrayList($list);
    	$arrayList->add('kancloud');
    	$arrayList->unique();
    	dump($arrayList->toArray());
    	echo $arrayList->toJson();
    }
}
