<?php
	namespace app\index\model;
	use think\Model;

	class User extends Model
	{
		//1.读取器
		//birthday读取器
		// protected function getBirthdayAttr($birthday){
		// 	return date('Y-m-d', $birthday);
		// }	

		//user_birthday读取器
		protected function getUserBirthdayAttr($value, $data){
			return date('Y-m-d', $data['birthday']);
		}

		//2.修改器
		//birthday修改器
		// protected function setBirthdayAttr($value){
		// 	return strtotime($value);

		// }

		// 类型转换
		//protected $dataFormat = 'Y/m/d';
		protected $type       = [
			// 设置birthday为时间戳类型（整型)）
			'birthday' => 'timestamp:Y/m/d',
			'create_time' => 'timestamp:Y/m/d',
			'update_time' => 'timestamp:Y/m/d',
		];

		//定义时间戳字段名
		protected $create_Time = 'create_at';
		protected $update_time = 'update_at';

		//关闭自动写入时间戳
		// protected $autoWriteTimetamp = false;

		// 指定自动写入时间戳的类型为dateTime类型
		protected $autoWriteTimestamp = 'datetime';

		// 定义自动完成的属性
		protected $insert = ['status'];

		// status属性修改器
		protected function setStatusAttr($value, $data){
			return '流年' == $data['nickname'] ? 1 : 2;
		}

		//status属性读取器
		protected function getStatusAttr($value){
			$status = [-1 => '删除' , 0 => '禁用', 1 => '正常', 2 => '待审核'];
			return $status[$value];
		}

		//查询范围
		// email查询
		protected function scopeEmail($query){
			$query->where('email', 'thinkphp@qq.com');
		}

		// status查询
		protected function scopeStatus($query){
			$query->where('status', 1);
		}

		// 全局查询范围
		protected static function base($query){

			//查询状态为1的数据
			$query->where('status', 1);
		}
	}
    
    //设置完整的数据表
    /*
    namesapce app\index\model;
    user think\Model;

    class User extends Model
    {
    	//设置完整的数据表（包含前缀）
    	protected $table = 'think_user';
    }
	*/


    //设置不带前缀的数据表名
    /*
    namesapce app\index\model;
    user think\Model;

    class User extends Model
    {
    	//设置完整的数据表（不包含前缀）
    	protected $name= 'member';
    }
	*/


    //设置单独的数据库连接
    /*
	namespace app\index\model;
	use think\Model;
	class User extends Model
	{
		// 设置单独的数据库连接
		protected $connection = [
		// 数据库类型
		'type' => 'mysql',
		// 服务器地址
		'hostname' => '127.0.0.1',
		// 数据库名
		'database' => 'test',
		// 数据库用户名
		'username' => 'root',
		// 数据库密码
		'password' => '',
		// 数据库连接端口
		'hostport' => '',
		// 数据库连接参数
		'params' => [],
		// 数据库编码默认采用utf8
		'charset' => 'utf8',
		// 数据库表前缀
		'prefix' => 'think_',
		// 数据库调试模式
		'debug' => true,
		];
	}
	*/
?>