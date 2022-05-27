<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

//获取Token
Route::post('api/:version/token/user', 'api/:version.Token/getToken');
//Route::get('api/:version/user/:id','api/:version.Syhqx/read');
//查询部门/用户二维数组，供用户登陆使用
Route::get('api/:version/users', 'api/:version.Syhqx/getUsers');
Route::get('api/:version/salemans', 'api/:version.Syhqx/getSalemans');
Route::get('api/:version/user', 'api/:version.Syhqx/getAll');
Route::get('api/:version/user/:id', 'api/:version.Syhqx/getUserById');
Route::post('api/:version/user/login', 'api/:version.Syhqx/check');
Route::post('api/:version/user/login_saleman', 'api/:version.Syhqx/checkSaleman');
Route::post('api/:version/user/edit', 'api/:version.Syhqx/edit');
Route::post('api/:version/user/save_phone', 'api/:version.Syhqx/savePhoneNum');
Route::post('api/:version/user/check_phone', 'api/:version.Syhqx/checkPhoneNum');

//用户权限
Route::post('api/:version/scope/single', 'api/:version.Syhqxd/getSingleScope');
Route::post('api/:version/scope/Multiple', 'api/:version.Syhqxd/getMultipleScope');

//员工档案---搅拌车司机
Route::get('api/:version/driver', 'api/:version.Sygda/getRecent');
Route::get('api/:version/driver/:id', 'api/:version.Sygda/getDriver');
Route::post('api/:version/driver/login', 'api/:version.Sygda/login');
Route::post('api/:version/driver/save', 'api/:version.Sygda/save');
Route::post('api/:version/driver/driverCar', 'api/:version.Sygda/getDriverCar');
Route::post('api/:version/driver/edit', 'api/:version.Sygda/edit');

//客户管理模块
Route::get('api/:version/mcustomer/recent', 'api/:version.Mcustomer/getRecent');
Route::get('api/:version/mcustomer/:id', 'api/:version.Mcustomer/getOne');
Route::post('api/:version/mcustomer/sh', 'api/:version.Mcustomer/setSH');
Route::post('api/:version/mcustomer/state', 'api/:version.Mcustomer/setState');
Route::post('api/:version/mcustomer/login', 'api/:version.Mcustomer/login');
Route::post('api/:version/mcustomer/save', 'api/:version.Mcustomer/save');
Route::post('api/:version/mcustomer/edit', 'api/:version.Mcustomer/edit');

//施工单位模块
Route::post('api/:version/mbuilder/login', 'api/:version.Mbuilder/login');
Route::post('api/:version/mbuilder/edit', 'api/:version.Mbuilder/edit');

//合同订单
Route::get('api/:version/mpactm/recent', 'api/:version.Mpactm/getRecent');
Route::get('api/:version/mpactm/by_name', 'api/:version.Mpactm/getMpactmsByName');
Route::get('api/:version/mpactm/by_state', 'api/:version.Mpactm/getMpactmsByState');
Route::get('api/:version/mpactm/:id', 'api/:version.Mpactm/getOne');
Route::post('api/:version/mpactm/recentwhere', 'api/:version.Mpactm/getRecentWhere');
Route::post('api/:version/mpactm/sh', 'api/:version.Mpactm/setSH');
Route::post('api/:version/mpactm/state', 'api/:version.Mpactm/setState');
Route::post('api/:version/mpactm/betoninfo', 'api/:version.Mpactm/getBetoninfoByType');

//合同明细
Route::get('api/:version/mpactd/greads/:id', 'api/:version.Mpactd/getGreadListByProjectid');
Route::get('api/:version/mpactd/tsnames/:id', 'api/:version.Mpactd/getTsNameListByProjectid');


//订货单
//Route::get('api/:version/mpplancust/recent', 'api/:version.Mpplancust/getRecent');
//Route::get('api/:version/mpplancust/by_name', 'api/:version.Mpplancust/getInfoByName');
//Route::get('api/:version/mpplancust/by_state', 'api/:version.Mpplancust/getInfoByOrderType');
//Route::get('api/:version/mpplancust/:id', 'api/:version.Mpplancust/getOne',[], ['id' => '\d+']);
Route::get('api/:version/mpplancust/:id', 'api/:version.Mpplancust/getOne',[]);
Route::post('api/:version/mpplancust/recentWhere', 'api/:version.Mpplancust/getRecentWhere');
Route::post('api/:version/mpplancust/sh', 'api/:version.Mpplancust/setSH');
Route::post('api/:version/mpplancust/state', 'api/:version.Mpplancust/setState');
Route::post('api/:version/mpplancust/edit', 'api/:version.Mpplancust/edit');
Route::post('api/:version/mpplancust/modify', 'api/:version.Mpplancust/modify');
Route::post('api/:version/mpplancust/copy', 'api/:version.Mpplancust/copyNew');
//通过orderService新增订单
Route::post('api/:version/mpplancust/create', 'api/:version.Mpplancust/createOrder');





//混凝土产品分页查询
Route::get('api/:version/mbetoninfo/recent', 'api/:version.Mbetoninfo/getRecent');
//根据类别获取产品列表：强度、特殊要求、坍落度、施工方式
Route::post('api/:version/mbetoninfo/typelist', 'api/:version.Mbetoninfo/getListByBetonType');


//销售每日对账单
Route::post('api/:version/msaleday/recent', 'api/:version.Msaleday/getRecent');

//计划单
Route::post('api/:version/mpplan/recent', 'api/:version.Mpplan/getRecent');
Route::get('api/:version/mpplan/:id', 'api/:version.Mpplan/getOne');
Route::post('api/:version/mpplan/sh', 'api/:version.Mpplan/setSH');
Route::post('api/:version/mpplan/state', 'api/:version.Mpplan/setState');

//生产配方
Route::post('api/:version/mphbprod/recent', 'api/:version.Mphbprod/getRecent');
Route::post('api/:version/mphbprod/single', 'api/:version.Mphbprod/getOne');

//标准配方
Route::post('api/:version/mphbm/recent', 'api/:version.Mphbm/getRecent');
Route::get('api/:version/mphbm/:id', 'api/:version.Mphbm/getOne');

//发货单
Route::post('api/:version/msaleodd/recent', 'api/:version.Msaleodd/getRecent');
//生产统计（按送货单）
Route::post('api/:version/msaleodd/msalestatmonth', 'api/:version.Msaleodd/getMSaleStatMonth');
Route::get('api/:version/msaleodd/recent/:id', 'api/:version.Msaleodd/getRecentByPlanid',[]);
Route::get('api/:version/msaleodd/:id', 'api/:version.Msaleodd/getOne',[]);

//生产记录清单--主表
Route::post('api/:version/mproductrecm/recent', 'api/:version.Mproductrecm/getRecent');
//生产统计（按生产记录）
Route::post('api/:version/mproductrecm/mprodstatday', 'api/:version.Mproductrecm/getMProdStatDay');
Route::get('api/:version/mproductrecm/:id', 'api/:version.Mproductrecm/getOne');

//车辆排队--停车场分流模式
Route::get('api/:version/carledviewzb/ledview', 'api/:version.Carledviewzb/ledview');

//车辆排队--标准模式
Route::get('api/:version/carpaiduim/ledview', 'api/:version.Carpaiduim/ledview');
Route::get('api/:version/carpaiduim/update', 'api/:version.Carpaiduim/update');

//车辆运输统计（按车辆）
Route::post('api/:version/tmpcarstat/car', 'api/:version.Tmpcarstat/getRecentByCar');

//车辆运输统计（按司机）
Route::post('api/:version/tmpcarstat/driver', 'api/:version.Tmpcarstat/getRecentByDriver');

//车辆运输统计（按司机）
Route::post('api/:version/tmpcarstat/car2driver', 'api/:version.Tmpcarstat/getRecentByCarAndDriver');

//材料资料
Route::get('api/:version/matinfo/recent', 'api/:version.Matinfo/getRecent');

//材料供应商
Route::get('api/:version/matsupplier/recent', 'api/:version.Matsupplier/getRecent');

//材料入库
Route::get('api/:version/matin/recent', 'api/:version.Matin/getRecent');
Route::post('api/:version/matin/recentWhere', 'api/:version.Matin/getRecentWhere');

//材料消耗
Route::post('api/:version/mproductrecd/recent', 'api/:version.Mproductrecd/getSummary');

//仓位材料盘点
Route::get('api/:version/matcwm/recent', 'api/:version.Matcwm/getRecent');

//仓位材料库存
Route::post('api/:version/cw_stat/recent', 'api/:version.Tmpcwiostat/getRecent');

//料位库存
Route::post('api/:version/lw_stat/recent', 'api/:version.Matstoreiostat/getRecent');
Route::post('api/:version/lw_stat_now/recent', 'api/:version.Matstorestatnow/getRecent');

//车辆资料
Route::get('api/:version/carinfo/recent', 'api/:version.Carinfo/getRecent');
Route::post('api/:version/carinfo/save', 'api/:version.Carinfo/save');
Route::post('api/:version/carinfo/statistics', 'api/:version.Carinfo/statistics');
Route::post('api/:version/carinfo/group', 'api/:version.Carinfo/groupData');
Route::post('api/:version/carinfo/changecar', 'api/:version.Carinfo/changeCar');
//生成所有车号的二维码图片
Route::post('api/:version/carinfo/qrcodes', 'api/:version.Carinfo/getQrcodes');
Route::get('api/:version/carinfo/:id', 'api/:version.Carinfo/getOne');
Route::get('api/:version/carinfo/car/:id', 'api/:version.Carinfo/getByDriverID');
//根据车号生成二维码图片
Route::get('api/:version/carinfo/qrcode/:id', 'api/:version.Carinfo/getQrcode');


//单据代码生成
Route::post('api/:version/coding', 'api/:version.Coding/getCode');


//坍落度
Route::get('api/:version/bbtld/recent', 'api/:version.Bbtld/getRecent');

//施工方式
Route::get('api/:version/bbtrans/recent', 'api/:version.Bbtrans/getRecent');

//基础数据读取，区域、业务员、结款类型等
Route::post('api/:version/basedata/recent', 'api/:version.Basedata/getBasedata');

//获取微信openId
Route::post('api/:version/wx/openid', 'api/:version.Wx/getOpenId');

//aliyunoss接口测试
Route::get('api/:version/aliyunoss/upload', 'api/:version.Aliyunoss/uploadFile');



// +----------------------------------------------------------------------
// | gps接口
// +----------------------------------------------------------------------

//index页
Route::get('gps/:version/index/index', 'gps/:version.Index/index');

//车辆信息
Route::get('gps/:version/uvehicle/recent', 'gps/:version.UVehicles/getRecent');
Route::get('gps/:version/uvehicle/work_status_group', 'gps/:version.UVehicles/workStatusGroup');

//待命车辆
Route::get('gps/:version/uvehicle/working', 'gps/:version.UVehicles/getWorkingVehicles');


//查询正在运输中的送货单
Route::get('gps/:version/utasks/transing','gps/:version.UTasks/getTransTasks');



//任务单_正供
Route::get('gps/:version/umissions/running', 'gps/:version.Umissions/getRunningMissions');


//查询搅拌站信息（包含电子围栏）
Route::get('gps/:version/c_factory_site/list', 'gps/:version.CFactorySite/getList');

//获取所有车辆的定位信息
Route::get('gps/:version/vehicles/points', 'gps/:version.VehiclesGPS/getVehiclesGPS');
Route::get('gps/:version/vehicles/point/:id', 'gps/:version.VehiclesGPS/getVehiclePoint');







