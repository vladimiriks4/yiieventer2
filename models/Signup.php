<?php

namespace app\models;

use yii\base\Model;

class Signup extends Model
{
    public $name;
    public $password;
    public $email;
//    public $role_id;

    public function  rules()
    {
        return [
            [['name','email','password'], 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => 'app\models\Users'],
//            ['role_id', 'integer']
        ];
    }

    public function signup()
    {
        $user = new Users();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = $this->password;
//        $user->role_id = $this->role_id;
        return $user->save(); //true or false

    }
}
