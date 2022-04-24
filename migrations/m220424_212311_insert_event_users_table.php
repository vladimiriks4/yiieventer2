<?php

use yii\db\Migration;

/**
 * Class m220424_212311_insert_event_users_table
 */
class m220424_212311_insert_event_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('event_users' , ['event_id', 'users_id', 'ban', 'org'],
            [
                [1,1,0,1],
                [2,2,0,1],
                [2,5,0,0],
                [2,6,0,0],
                [3,3,0,1],
                [3,5,0,0]
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('event_users', ['event_id' => [1,2,3]]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220424_212311_insert_event_users_table cannot be reverted.\n";

        return false;
    }
    */
}
