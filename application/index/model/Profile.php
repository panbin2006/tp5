<?php
	namespace app\index\model;
	use think\model;
	class  Profile extends Model{
		//类型转换
		protected $type =[
			'birthday' => 'timestamp:Y-m-d',
		];

		public function user(){
			//档案BELONGS TO 关联用户
			return $this->belongsTo('user');
		}

	}
?>