<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "permission".
 *
 * @property int $id
 * @property string|null $action
 * @property int|null $role_id
 */
class Permission extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'permission';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_id'], 'integer'],
            [['action'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'action' => 'Action',
            'role_id' => 'Role ID',
        ];
    }

    public function getRole()
    {
        return $this->hasMany(Role::class, ['id' => 'role_id'])
            ->viaTable('permission_role', ['permission_id' => 'id']);
    }
}
