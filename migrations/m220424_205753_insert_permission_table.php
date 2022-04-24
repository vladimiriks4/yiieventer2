<?php

use yii\db\Migration;

/**
 * Class m220424_205753_insert_permission_table
 */
class m220424_205753_insert_permission_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $arrVal = [
            ['show-profile','получить персональные данные'],
            ['recovery','восстановить пароль'],
            ['ban','бан юзера'],
            ['invite','приглос юзера'],
            ['addUser','добавить юзера изменить ему роль'],
            ['delete-user','удалить узера'],
            ['add-org','добавить организатора'],
            ['delete-org','удалить организатора'],
            ['update-profile','обновить профиль'],
        ];

        $this->batchInsert('permission' , ['action', 'title'],
                $arrVal
            );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('permission', ['title' => [
            'получить персональные данные',
            'восстановить пароль',
            'бан юзера',
            'приглос юзера',
            'добавить юзера изменить ему роль',
            'удалить узера',
            'добавить организатора',
            'удалить организатора',
            'обновить профиль'
        ]]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220424_205753_insert_permission_table cannot be reverted.\n";

        return false;
    }
    */
}
