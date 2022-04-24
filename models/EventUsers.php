<?php

namespace app\models;

use Yii;

///**
// * This is the model class for table "event_users".
// *
// * @property int $event_id
// * @property int $users_id
// * @property boolean $ban
// *
// * @property Event $event
// * @property Users $users
// */
class EventUsers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event_users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_id', 'users_id'], 'required'],
            [['event_id', 'users_id'], 'integer'],
            [['ban'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'event_id' => 'Event ID',
            'users_id' => 'User ID',
            'ban' => 'Ban',
        ];
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::className(), ['id' => 'users_id']);
    }

    /**
     * Gets query for [[Event]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::className(), ['id' => 'event_id']);
    }
}
