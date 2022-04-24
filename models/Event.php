<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "event".
 *
 * @property int $id
 * @property string $title
 * @property int|null $org_id
 *
 * @property EventUsers[] $eventUsers
 * @property Users[] $users
 */
class Event extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'safe'],
//            [['title'], 'required'],
            [['org_id'], 'integer'],
//            [['title'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'org_id' => 'Org ID',
        ];
    }

    /**
     * Gets query for [[EventUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEventUsers()
    {
        return $this->hasMany(EventUsers::className(), ['event_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['id' => 'users_id'])
            ->viaTable('event_users', ['event_id' => 'id']);
    }

    public static function findModelByTitle($title)
    {
        return self::findOne(['title' => $title]);
    }

    public function getId()
    {
        return $this->id;
    }
}
