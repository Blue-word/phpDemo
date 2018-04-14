<?php
namespace app\admin\model;

use think\Model;

class User extends Model
{
	public function profile()
    {
        return $this->hasOne('user_related','uid','uid');
    }

}