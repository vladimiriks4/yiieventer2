<?php

use yii\db\Migration;

/**
 * Class m220424_201835_insert_event_table
 */
class m220424_201835_insert_event_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('event' , ['title'],
            [
                ['php forever'],
                ['winter'],
                ['do it everywhere'],
                ['stop it'],
                ['some else'],
                ['and more'],
                ['wow']
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('event', ['title' => [
            'php forever',
            'winter',
            'do it everywhere',
            'stop it',
            'some else',
            'and more',
            'wow'
        ]]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220424_201835_insert_event_table cannot be reverted.\n";

        return false;
    }
    */
}
