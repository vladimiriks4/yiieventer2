<?php

use yii\db\Migration;

/**
 * Class m220424_202610_insert_users_table
 */
class m220424_202610_insert_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('users' , ['name', 'password', 'email', 'role_id'],
            [
                ['jony','1234','jony@mail.ru',1],
                ['pony','1234','pony@mail.ru',2],
                ['sony','1234','sony@mail.ru',2],
                ['dony','1234','dony@mail.ru',3],
                ['lony','1234','lony@mail.ru',3],
                ['rony','1234','rony@mail.ru',3],
                ['tony','1234','tony@mail.ru',3],
                ['hony','1234','hony@mail.ru',3],
                ['bony','1234','bony@mail.ru',3],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('users', ['email' => [
            'jony@mail.ru',
            'pony@mail.ru',
            'sony@mail.ru',
            'dony@mail.ru',
            'lony@mail.ru',
            'rony@mail.ru',
            'tony@mail.ru',
            'hony@mail.ru',
            'bony@mail.ru',
        ]]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220424_202610_insert_users_table cannot be reverted.\n";

        return false;
    }
    */
}
