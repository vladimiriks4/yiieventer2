<?php

use yii\db\Migration;

/**
 * Class m220424_201353_insert_role_table
 */
class m220424_201353_insert_role_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('role' , ['id', 'name'],
            [
                [1,'admin'],
                [2,'org'],
                [3,'user'],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('role', ['id' => [1,2,3]]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220424_201353_insert_role_table cannot be reverted.\n";

        return false;
    }
    */
}
