<?php
	namespace app\index\model;

	use think\Model;

	class Role extends Model{
		public function user(){
			// 角色 BELONGS_TO_MANY 用户
			return  $this->belongTomany('User', 'access');
		}
	}
?>