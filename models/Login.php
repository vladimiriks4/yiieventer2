<?php

namespace app\models;

use yii\base\Model;


class Login extends Model
{
    public $password;
    public $email;

    public function  rules()
    {
        return [
            [['email','password'], 'required'],
            ['email', 'email'],
            ['password', 'validatePassword'] //задали в правилах валидации собственную функцию
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) { //если нет ошибок в валидации

            $user = $this->getUser(); //получаем пользователя для сравнения пароля

            if (!$user || !$user->validatePassword($this->password)) { // если не нашли юзера или пароль неверный то ошибка
                $this->addError($attribute, 'Пароль или юзер неверны');
            }
        }
    }

    public function getUser()
    {
        return Users::findOne(['email' => $this->email]); //поиск по имейлу
    }
}
