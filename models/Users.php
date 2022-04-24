<?php

namespace app\models;

use app\models\Role;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\NotFoundHttpException;

//class Users extends ActiveRecord
class Users extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'role_id'], 'integer'],
            [['name', 'password'], 'string', 'max' => 45],
            [['email'], 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'password' => 'PWD',
            'email' => 'Email',
            'role_id' => 'Role_id',
        ];
    }

    public function validatePassword($password)
    {
        return $password === $this->password;
    }

    //юзер принадлежить\имеет одну роль
    public function getRole()
    {
        return $this->hasOne(Role::class, ['id' => 'role_id']);
//        return $this->hasOne(Role::className(), ['id' => 'role_id']);
    }

    public function getEvent()
    {
        return $this->hasMany(Event::class, ['id' => 'event_id'])
            ->viaTable('event_users', ['users_id' => 'id']);
    }

    /**
     * Gets query for [[EventUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEventUsers()
    {
        return $this->hasMany(EventUsers::class, ['users_id' => 'id']);
    }


    public function getName()
    {
        return $this->name;
    }

    public static function findModelByEmail($email)
    {
        if (($model = Users::findOne(['email' => $email])) !== null) {
            return $model;
        }
        return null;
//        throw new NotFoundHttpException('The requested page does not exist.');
    }







    ////// реализация методов интерфейса идентификации


    public static function findIdentity($id)
    {
        return self::findOne($id);
        // TODO: Implement findIdentity() method.
    }

    public function getId()
    {
        return $this->id;
        // TODO: Implement getId() method.
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }
}
