<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "permission_role".
 *
 * @property int $permission_id
 * @property int $role_id
 *
 * @property Permission $permission
 * @property Role $role
 */
class PermissionRole extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'permission_role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['permission_id', 'role_id'], 'required'],
            [['permission_id', 'role_id'], 'integer'],
            [['permission_id', 'role_id'], 'unique', 'targetAttribute' => ['permission_id', 'role_id']],
            [['permission_id'], 'exist', 'skipOnError' => true, 'targetClass' => Permission::className(), 'targetAttribute' => ['permission_id' => 'id']],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'permission_id' => 'Permission ID',
            'role_id' => 'Role ID',
        ];
    }
}
