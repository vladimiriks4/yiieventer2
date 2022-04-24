<?php

namespace app\models;

use Yii;
use app\models\Users;

/**
 * This is the model class for table "role".
 *
 * @property int $id
 * @property string|null $name
 */
class Role extends \yii\db\ActiveRecord
{
    const ROLE_ADMIN = 1;
    const ROLE_ORG = 2;
    const ROLE_USER = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 45],
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
        ];
    }

    public function getUsers()
    {
        return $this->hasMany(Users::class, ['role_id' => 'id']);
    }

    public function getPermission()
    {
        return $this->hasMany(Permission::class, ['id' => 'permission_id'])
            ->viaTable('permission_role', ['role_id' => 'id']);
    }
}
