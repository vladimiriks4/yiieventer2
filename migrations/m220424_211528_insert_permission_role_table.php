<?php

use yii\db\Migration;

/**
 * Class m220424_211528_insert_permission_role_table
 */
class m220424_211528_insert_permission_role_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('permission_role' , ['permission_id', 'role_id'],
            [
                [1,1],
                [1,2],
                [1,3],
                [2,1],
                [2,2],
                [2,3],
                [3,1],
                [3,2],
                [4,2],
                [5,1],
                [6,1],
                [7,1],
                [8,1],
                [9,1]
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('permission_role', ['role_id' => [1,2,3]]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220424_211528_insert_permission_role_table cannot be reverted.\n";

        return false;
    }
    */
}
