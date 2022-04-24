<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%event_users}}`.
 */
class m220424_195744_create_event_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%event_users}}', [
            'event_id' => $this->integer(),
            'users_id' => $this->integer(),
            'ban' => $this->boolean()->defaultValue(false),
            'org' => $this->boolean()->defaultValue(false),
            'PRIMARY KEY(event_id, users_id)',
        ]);

        // creates index for column `event_id`
        $this->createIndex(
            '{{%idx-event_users-event_id}}',
            '{{%event_users}}',
            'event_id'
        );

        // add foreign key for table `{{%event}}`
        $this->addForeignKey(
            '{{%fk-event_users-event_id}}',
            '{{%event_users}}',
            'event_id',
            '{{%event}}',
            'id',
            'CASCADE'
        );

        // creates index for column `users_id`
        $this->createIndex(
            '{{%idx-event_users-users_id}}',
            '{{%event_users}}',
            'users_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-event_users-users_id}}',
            '{{%event_users}}',
            'users_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%event}}`
        $this->dropForeignKey(
            '{{%fk-event_users-event_id}}',
            '{{%event_users}}'
        );

        // drops index for column `event_id`
        $this->dropIndex(
            '{{%idx-event_users-event_id}}',
            '{{%event_users}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-event_users-users_id}}',
            '{{%event_users}}'
        );

        // drops index for column `users_id`
        $this->dropIndex(
            '{{%idx-event_users-users_id}}',
            '{{%event_users}}'
        );

        $this->dropTable('{{%event_users}}');
    }
}
